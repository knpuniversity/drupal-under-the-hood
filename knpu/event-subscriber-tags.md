# Event Subscribers and Dependency Injection Tags

Here's the challenge: add a function that will be called on *every* request, right
at the beginning, before any controller is called. This means we should hook into
the `kernel.request` event.

## Create an Event Subscriber

In the `Jurassic` directory - well, it doesn't matter where - add a new `DinoListener`
class. Next, make this class implement `EventSubscriberInterface`:

[[[ code('537aa39fcd') ]]]

If you're not *super* cool with interfaces yet, hit pause and go practice with them
in the [Object Oriented Level 3](https://knpuniversity.com/screencast/oo-ep3) course.

This interface forces us to have 1 method: `getSubcribedEvents()`. In PhpStorm,
hit `command+n` to bring up the Generate menu, select "Implement Methods", and
highlight this. That's a nice shortcut to add the *one* method we need:

[[[ code('4fba2c28ee') ]]]

We need to tell Drupal *which* event we want to listen to and *what* method to call
when that event happens. This method returns an array that says exactly that. Use
`KernelEvents::REQUEST` as the key and hit `tab` to auto-complete and get the `use`
statement. But hold on, that is *just* a constant that means `kernel.request`. You
can totally use the string `kernel.request` if you want to. The value is the method
to call. Use, `onKernelRequest()`:

[[[ code('a99480c447') ]]]

Up top, create that method: `public function onKernelRequest()`. Every event listener
is passed exactly *one* argument: an event object:

[[[ code('0c2d2e75a9') ]]]

The cool thing is that this object will hold any information your function will need.
The tricky thing is that this is a different object depending on *which* event you're
listening to.

No worries, let's just `var_dump()` it and see what it is!

[[[ code('62a637bd4d') ]]]

## Configuring an Event Subscriber

Ok, this class is setup. The last step is to tell Drupal we have an event subscriber.
How do you do that? Register this class as a service. Get used to that answer.

In `dino_roar.services.yml`, add a new service - the name doesn't matter. Set the
class to the full namespace. In this case, there are *no* constructor arguments.
Add an `arguments` key, but leave it blank with square brackets:

[[[ code('c2c2a4aa54') ]]]

Congratulations! You've created a normal, boring service... but Drupal still doesn't
know it's an event subscriber. Somehow, we need to tell Drupal:

> Yo, this is *not* a normal service, this is an event subscriber!
> I want you to call the `getSubscribedEvents()` method so you know
> about my `kernel.request` listener!

Whenever you want to raise your hand and scream "Drupal, this service is special,
use it for this core purpose", you're going to use a tag. The syntax for a tag
is ugly, but here it goes. Add `tags`, add a new line, indent, add a dash, then
a set of curly braces. Every tag has a name: this one is `event_subscriber`:

[[[ code('4188f27413') ]]]

By doing this, you've now told Drupal's core that our `DynoListener` service is an
event subscriber. It knows to go in and find out what events we're subscribed to.

## What are these Dependency Injection Tags?

***seealso
Tags work via a system called "Compiler Passes". These are shared with Symfony,
and we talk a lot more about them here:
[Compiler Pass and Tags](https://knpuniversity.com/screencast/symfony-journey-di/compiler-passes#compiler-pass-and-tags).
***

There are other tags that for other things. For example, if you want to add some
custom functions to Twig, you'll create a class that extends `Twig_Extension`, register
it as a service, and tag it with `twig.extension`. This tells Twig, "Yo, I have
a Twig Extension here - use it!".

If you're using tags, then you're probably doing something geeky-cool, hooking into
some core part of the system. And you don't need to know about all the tags. You'll
Google "how do I register an event subscriber" and see that it uses a tag called
`event_subscriber`. You just need to understand how they work: that it's your way
of making your service special.

Ok, back to the action. Rebuild the cache:

```
drupal cache:rebuild
```

Since the `kernel.request` event happens on every request, we should be able to refresh
and see the `var_dump()`. Great Scott! There it is! Now, let's do something in this!
