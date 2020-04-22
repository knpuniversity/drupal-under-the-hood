# How to Get a Service in the Controller

There's a `dino_roar.roar_generator` service in the container and gosh darnit, I
want to use this in my controller!

## The ControllerBase Class

First, notice that `RoarController` is *not* extending anything. That's cool: your
controller does *not* need to extend anything: Drupal doesn't care. That being said,
most of the time a controller will extend a class called `ControllerBase`. Add it
and hit tab so the `use` statement is added above the class:

[[[ code('741f86bcc8') ]]]

This has a lot of cool shortcut methods - we'll look at some soon. But more importantly,
it gives us a new super-power: the ability to get services out of the container. 

## Override create()

***TIP
An alternative to the following method is to register your controller as a service
and refer to it in your routing with a `your_service_name:methodName` syntax (e.g.
`dino.roar_controller:roar`). This allows you to pass other services into your controller
without needing to add the `create` function. For more info, see
[Structure of Routes](https://www.drupal.org/docs/8/api/routing-system/structure-of-routes).
***

I'll use the shortcut [command+n](http://knpuniversity.com/screencast/phpstorm/doctrine),
select "Override" from the menu and override the `create` function that lives in
the base class:

[[[ code('7a339baa67') ]]]

You don't need to use PhpStorm to override this, it's just fast and fancy. It also
added the `use` statement for the `ContainerInterface`. When your controller needs
to access services from the container, this is step 1.

Before we had this, Drupal instantiated our controller automatically. But now, it
will call *this* function and expect *us* to create a new `RoarController` and return
it. And hey, it passes us the `$container`!!! There it is, finally! The container
is the *most important* object in Drupal... and guess what? It has only *one* important
method on it: `get()`. I bet you can guess what it does.

Create a `$roarGenerator` variable, set it to `$container->get('');` and pass it the name
of the service: `dino_roar.roar_generator`:

[[[ code('bd344bac29') ]]]

Behind the scenes, Drupal will instantiate that object and give it to us. To create
the `RoarController`, `return new static();` and pass it `$roarGenerator`:

[[[ code('5b330fa21b') ]]]

This may look weird, but stay with me. The `new static` part says:

> Create a new instance of `RoarController` and return it, please".

Again, manners are good for performance in D8.

## Controller __construct() Method

Next, create a constructor: `public function __construct()`.When we instantiate
the controller, we're choosing to pass it `$roarGenerator`. So add that as an argument:

[[[ code('88775ebef2') ]]]

I'll even type-hint it with `RoarGenerator` to be super cool. Type-hinting is
optional, but it makes us best friends.

Finally, create a `private $roarGenerator` property and set it with
`$this->roarGenerator = $roarGenerator;`:

[[[ code('fc232b3d02') ]]]

Ok, this was a *big* step. As soon as we added the `create()` function, it was now
*our* job to create a `new RoarController`. And of course, we can pass it whatever it
needs to its constructor - like objects or configuration. That's really handy since
we have access to the `$container` and can fetch out any service and pass it to
the new controller object.

In the `__construct` function, we don't use the `RoarGenerator` yet: we just set
it on a property. That saves it for use later. Then, 5, 10, 20 or 100 miliseconds
later when Drupal finally calls the `roar()` function, we know that the `roarGenerator`
property holds a `RoarGenerator` object.

Delete the `new RoarGenerator` line and instead use `$this->roarGenerator` directly:

[[[ code('8d9af33fbd') ]]]

Woh. Moment of truth: go back to the browser, change the URL and hit enter to reload
the page. OMG! It still works!

## It's Dependency Injection!

It is *ok* if this was confusing for you. This - by the way - is called dependency
injection. Buzzword! Actually, it's kind of a hard application of dependency injection.
I'll show you a simpler and more common example in a second. But once you wrap your
head around this pattern, you will be unstoppable.

## Why did I put my Service in the Container?

Why did we go to all this trouble? After all, this only saved us *one* line in the
controller: the `new RoarGenerator()` line.

Two reasons, *big* reasons. First, I keep telling you the container is like an array
of all the useful objects in the system. Ok, that's *kind* of a lie. It's more like
an array of *potential* objects. The container doesn't instantiate a service until
*and unless* someone asks for it. So, until we actually hit the line that asks for
the `dino_roar.roar_generator` service, your app doesn't use the memory or CPUs needed
to create that.

For something big like Drupal, it means you can have a *ton* of services without
slowing down your app. If you don't use a service, it's not created.

And if *ten* places in your code ask for the `dino_roar.roar_generator` service,
it gives each of them the same *one* object. That's awesome: you might need a
`RoarGenerator` in 50 places but you don't want to waste memory creating 50 objects.
The container takes care of that for us: it only creates *one* object.

The second big benefit of registering a service in the container isn't obvious yet,
but I'll show that next. It deals with constructor arguments.

## Fetch another Service: a Logger

Now that we have this pattern with the `create` function and `__construct`, we're
dangerous! We can grab *any* service from the container!

Go to the terminal and run `container:debug` and grep for `log`:

```bash
drupal container:debug | grep log
```

Interesting: there's a service called `logger.factory` that can be used to, um ya
know, log stuff. Let's see if we can log the ROOOOOAR message from the controller.

In `RoarController` add `$loggerFactory = $container->get('logger.factory');` and
pass that as the second constructor argument when creating `RoarController`:

[[[ code('6808e9a060') ]]]

### Type-Hinting Core Services

The `container:debug` command tells us that this is an instance of `LoggerChannelFactory`.
Use that as the type-hint. In the autocomplete, it suggests `LoggerChannelFactory`
and `LoggerChannelFactoryInterface`. That's pretty common. Often, a class will implement
an interface with a similar name. Interfaces are a bit more hipster, and in practice,
you can type-hint the original class name or the interface if you want to look super
cool in front of co-workers.

Call the argument `$loggerFactory`. I'll use a PhpStorm shortcut called
[initialize fields](http://knpuniversity.com/screencast/phpstorm/service-shortcuts#generating-constructor-properties)
to add that property and set it:

[[[ code('80629e7f66') ]]]

If you want to dive into PhpStorm shortcuts, you should: we have a
[full tutorial](http://knpuniversity.com/screencast/phpstorm) on it.

Now in the `roar()` function, use that property! Add `$this->loggerFactory->get('')`: this
returns one specific *channel* - there's one called `default`. Finish with `->debug()`
and pass it `$roar`:

[[[ code('b7fd72cf2b') ]]]

Congrats: we're now using our *first* service from the container.

Refresh to try it! To check the logs, head to a page that has the main menu, click
"Reports", then go into "Recent Log Messages." There it is! 

Not only did we add a service to the container, but we also used an existing one
in the controller. Considering how many services exist, that makes you very dangerous. 

Oh, and if this seemed like a lot of work to you, you're in luck! The Drupal Console
has *many* code generation commands to help you build routes, controllers, services
and more.
