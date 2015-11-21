# Event Arguments and the Request

We *now* know that when you listen to *this* event, it passes you an event object
called `GetResponseForEvent`. Type-hint the argument to enjoy auto-completion.

## Using the Event Argument

This event object has a `getRequest()` method, use that to set a new `$request`
variable. This is Drupal's - and Symfony's - Request object. If you want to read
some GET params, POST params, headers or session stuff, this is your friend. You
can of course [get the Request object inside a controller](http://knpuniversity.com/screencast/symfony2-ep2/form-submit#getting-the-request-object).

Here's the goal: if the URL has a `?roar=1` on it, then I want to log a message.
If not, we'll do nothing. Make a new variable called `$shouldRoar`. To access the GET,
or *query* parameters on the request, use `$request->query->get('roar')`. If it's
not there, this returns `null`.

Next, `if ($shouldRoar)`, just `var_dump('ROOOOAR')` and die to test things. Since
we didn't touch any configuration, we can refresh without clearing anything.

Page not found! We're on the profiler page for a past request, and this information
is stored in the cache... which we just cleared. So go find a real page. Ok, it
works perfectly. Now add `?roar=1`. It hits! And this will work on *any* page.

## Dependency Inject All the Things

How can we log something? We [faced this problem earlier](http://knpuniversity.com/screencast/drupal8-under-the-hood/service-arguments)
when we wanted to use the `keyvalue` store inside `RoarGenerator`. We solved it with
dependency injection: create a `__construct()` method, pass in what you need, and
set it on a property. This is no different.

Add `public function __construct()`. Look for the logger in `container:debug`:

```bash
drupal container:debug | grep log
```

The `logger.factory` is an instance of `LoggerChannelFactory`. Type-hint using that.
And like with other stuff, this has an interface, which is a trendier option. I'll
hit [option+enter](http://knpuniversity.com/screencast/phpstorm/service-shortcuts#generating-constructor-properties)
to add the property and set it.

Below, if you wanna roar, do it! `$this->loggerFactory->get()` - and use the `default`
channel. Then add a `debug` message: 'Roar requested: ROOOOOAR'.

That's it guys! We didn't touch any config, so just refresh. Oh no, an error:

> Argument 1 passed to DinoListener::__construct() must implement
> LoggerChannelFactoryInterface, none given.

Can you spot the problem? We saw this [once before](http://knpuniversity.com/screencast/drupal8-under-the-hood/service-arguments#configure-service-arguments).
We forgot to *tell* the container about the new argument. In `dino_roar.services.yml`,
add `@logger.factory`. This is a single-line YAML-equivalent to what I did for the
other service.

Rebuild the cache:

```bash
drupal cache:rebuild
```

Refresh. No error! Head into "Reports" and then "Recent Log Messages". There's the
"Roar Requested".

You're now an event listener pro. We listened to `kernel.reqeust`, but you can dd
a listener to *any* event that Drupal *or* third-party modules expose.
