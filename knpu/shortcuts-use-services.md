# The Magic Behind Shortcuts Methods is: Services

When we extended `ControllerBase`, we got access to the `create()` function. And
*that* gave us the ability to pass ourselves services. Color us dangerous!

But wait, there's more! `ControllerBase` gives us a *bunch* of helper functions.

For example, Drupal gives you access to a key value store that can be backed with
a database or something like Redis. As soon as you extend `ControllerBase` you can
get a key-value store by typing `$this->keyValue()` and passing it some collection
string.

Hey, let's take it for a test drive: `$keyValueStore->set('roar_string', $roar);`
Ok cool - let's store something: go to the url, with 50 as the value. Ding! Ok, nothing
visually happened, but the `roar_string` *should* be stored.

Let's see for sure: comment out the `$roar` equals and key-value store lines. Instead,
say `$roar = $keyValueStore->get()` and pass it `roar_string`. Refresh! The key-value
store WORKS!

And if I change the URL to 500, the length doesn't change: it's *still* pulling from
the store. This has nothing to do with understanding how Drupal works, but isn't
that cool?

But, question: what does this `keyValue()` function *really* do?

In PHPStorm, hold command - or control in Windows - and click this method! Bam! It
opens up `ControllerBase` - *deep* in the heart of Drupal - and shows us the real
`keyValue()` method. And hey, look at this: there is a function in controller base
called `container()` - it's a shortcut to get the service container, the same container
that is passed to us in the `create()` function.  It uses it to fetch out a service
called `keyvalue`.

Here's the really important thing: the "key value store" functionality isn't some weird,
core part of Drupal: it's just a service called `keyvalue` like any other service.
This means that if you need to use the key value store somewhere outside of the
controller, you just need to get access to the `keyvalue` service. And that is
*exactly* what I want to do inside of `RoarGenerator`.
