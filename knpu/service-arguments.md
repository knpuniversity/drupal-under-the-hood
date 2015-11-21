# Service Arguments

Pretend like the ROAR string calculation takes a really long time - like 2 seconds.
If that were true, we wouldn't want to generate it more than once: we'd want to cache
it in the key value store.

We already know how to access services from our controller: just use the `create()`
function workflow to pass more arguments to `__construct()`. And hey, sometimes,
it's even easier because there are shortcut methods that help do the common stuff.

But how can we get access to a service - like `keyvalue` from inside of another
service, like `RoarGenerator`? If you're thinking that we could make `RoarGenerator`
extend `ControllerBase`.... well, you're clever. But nope, sorry! That only works
for your controller.

## Accessing a Service inside a Service

Instead: here's the rule: as soon as you need access to a service from within a service,
we need to create a `__construct()` method and pass it as an argument. Run `container:debug`
and grep it for `keyvalue`:

```bash
drupal container:debug | grep keyvalue
```

This tells me that the `keyvalue` service is an instance of `KeyValueFactory`. Create
the `public function __construct()` and type-hint its first argument with this class.
Woh, but wait! Like before, there is a concrete class *and* a `KeyValueFactoryInterface`
that it implements. You can use either: interfaces are technically more correct
and much more hipster, but really, it doesn't matter. Name the argument `$keyValueFactory`
and open the method. I'll use [another shortcut](http://knpuniversity.com/screencast/phpstorm/doctrine#generating-the-repository),
alt enter on a mac, to initialize the field. That doesn't do anything special: it
just creates this private property and sets it.  

Ok, step back for a second. This is *really* similar to what we did in our controller
when we needed the `dino_roar.roar_generator` service. We're saying that *whoever*
creates the `RoarGenerator` will be *forced* to pass in an object that implements
`KeyValueFactory`. *Who* does that or *how* they do that, well, that's not our problem.
But once they do, we store it on a property so we can use it.

And use it we shall! First, create a cache `$key` called `roar_` and then the `$length`.
That'll give us a different cache key for each.  

Next, grab the key-value store itself with `$store = $this->keyValueFactory->get()`
and then the name of our store: `dino`. If the store *has* the key, return
`$store->get($key)` and save us from the long, slow 2 second sleep.

At the bottom, set the string to a variable and then store it with
`$store->set($key, $string)`. And don't forget to return `$string`. That's a perfect
cache setup.

Let's give this *cacheable* RoarGenerator a try. Back in the controller, undo everything
so we're using that service again. Ok, refresh!

## Configure Service Arguments

Ah, error!

> Call to a member function get*() on null, RoarGenerator line 22

Go check that out. Huh. Somehow, the `$keyValueFactory` is *not* set: it wasn't passed
into the `__construct()` method.

But wait. Who is instantiating the `RoarGenerator` anyways? The container is! We
registered it as a service, and Drupal says `new RoarGenerator()` as soon as we
ask for it. But it doesn't pass it *any* constructor arguments.

Somehow, we need to *teach* Drupal's container that "Hey, when you instantiate `RoarGenerator`,
it has a constructor argument. I need you to pass in the `keyvalue` service.".
To do that, add an `arguments` key.

This is an array, so I can hit enter and indent four spaces, or two spaces. Two
spaces is the Drupal standard. If I put the string `keyvalue`, it will *literally*
pass the string `keyvalue` as the first argument. That's not what we want! We want
the container to pass in the *service* called `keyvalue`.

The secret way to do that is with the `@` symbol.

Ok, we *just* made a configuration change, so rebuild the Drupal cache:

```bash
drupal cache:rebuild
```

Refresh! Ok, super slow - it's sleeeeping. Shhh... let it sleep. There it is! But
next time, it's super quick! Try 50. Slow.......... then fast the second time!

Maybe you didn't realize it, but we just had another big Eureka, buzzword-esque
moment. Yes! And that is: when you are inside a service - like `RoarGenerator` - and
you need access to another service or configuration value, you need to add a `__construct()`
argument for it and update your service's `arguments` to pass that in.

So if tomorrow, we need to *log* something from inside `RoarGenerator`, what are
we going to do? PANIC... is *not* the correct answer. No, we're going to calmly add
a *second* argument to the `__construct()` method then update `dino_roar.services.yml`
to configure this new argument.

A cool side-effect of this stuff is that even though we had to change how `RoarGenerator`
is created, we *didn't* need to change any of our code that uses it. In the controller,
we just ask for `dyno_roar.roar_generator`. The container looks to see if the `keyvalue`
service is already created. If it *isn't*, it creates it first and then passes it
to the `RoarGenerator`. No matter how complex creating `RoarGenerator` might become,
all we need to do is ask the container for it. All the ugly complications are hidden.
