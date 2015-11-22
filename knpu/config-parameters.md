# Configuration Parameters

New challenge: what if we need to turn off the key value store stuff while we're
developing, but keep it for production? Maybe you're thinking "just comment it out
temporarily!". That might work for you, but eventually, I'm going to forget to uncomment
it and deploy this to production with caching off. Then, traffic will run-over the
site and nobody will get any roars. I think we can do better.

Solution? Make `RoarGenerator` configurable. That means, add a new argument to
`__construct`: `$useCache`. Hit `option+enter` to create the property and set it.
This will be a boolean that controls whether or not we should cache.

Down below, update the `if` statement: `if $this->useCache` *and* the store has it,
then return it. Below, add another if statement that says we should *only* store
this in the cache if `$this->useCache` is true.

The `RoarGenerator` is now perfect: whoever creates it can control this behavior.
Because we added a second constructor argument, we need to update the service configuration.
Add another line with a `-` and set the second argument to `true`... for now.

Time to test: rebuild the cache:

```bash
drupal cache:rebuild
```

Refresh! The cache is activated... and everything is still really, really fast. If
you try `51`, that's not cached yet, but it's fast on the second load.

But this didn't solve our problem, it just moved the code we need to change from
`RoarGenerator` into the service file.

In addition to the `services` key - that can hold many services - these files are
allowed to have one other root key: `parameters`. The parameter system is a key-value
configuration system. This means... I lied to you! The service container isn't *just*
an array-like object that holds services. It also holds a key-value configuration
system called parameters.

Add a new parameter called `dyno.roar.use_key_value_cache` and set it to `true`.
To use this, I gotta tell you about the one *other* magic syntax in these files.
That is, use `%` - the name of the parameter - then `%`.  When you surround something
with percent signs, the container finds a parameter by this name and passes that.

And there's a bonus: these parameters can be accessed in any of these service files.
That means that if we define parameter A in one module, you can use it - or even
change it - somewhere else. This ends up being *critical* to how you can control
the *core* of Drupal. And yes, we'll talk about that soon!

But first, rebuild the cache real quick for a sanity check:

```bash
drupal cache:rebuild
```

Refresh! Everyone is still happy! We're awesome now with parameters... but we *still*
haven't *quite* solved our problem.
