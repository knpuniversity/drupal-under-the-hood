# Drupal Events versus Hooks

When I say Drupal, most people think: hooks. And then some people roll their eyes.
Yep, the infamous, but, honestly, super-powerful hooks system still exists. But not
everything uses hooks anymore: some use a brand new event system. With events, you
create a function and then tell Drupal to call your function when something happens.
Hmm.... that sounds a lot like hooks.

Yep! Events are the object-oriented version of hooks. And like hooks, if you can
learn how to harness events, you're going to be very, very dangerous.

First, get into the profiler by clicking any link on the web debug toolbar. Well
look at that: an Events tab. I think we should click it.

## Events versus Hooks

This is awesome: it tells you all of the events and the listeners that have been
called during this request. Wait, back up, new terminology. When something happens
in Drupal's core that we might want to hook into, Drupal dispatches an event. What
that really means is that Drupal calls all the functions that want to be executed
when this event happens.

And this works *just* like hooks. For example, when Drupal 7 builds the menu, it
knows you might want to hook into this process. So, it executes `hook_menu()`. What
this *really* means is that it calls all the functions that implement this hook.

So you can think of `hook_menu` as an "event", and all the callbacks that implement
it as the "listeners". In reality, the *only* difference between the hook system
and the event system is *how* you tell Drupal that you have a listener. With hooks,
create a function with *just* the right name - like `dino_roar_menu()` - and boom!
Drupal automagically calls it. With events, create a function with *any* name and
tell Drupal about it with configuration.

Each event has a name, and apparently there's one called `kernel.request`. This is
the *first* event that happens when the request is being processed. If you need some
code to run early on every page, this is your guy. On the right, there is a class
called `ProfilerListener` with an `onKernelRequest()` function. That's the listener
function that was called. In typical Drupal 8 fashion, it's not a flat-function
anymore: it's a method inside an object.

There are a bunch of listeners on `kernel.request` and several other events, like
`kernel.controller` and `render.page_display_variant.select`. Don't worry about
*why* you would want to listen to an event. Like with "hooks", you'll eventually
Google "How do I do X", and the answer will be "add a listener to some event".

At the bottom, there's another section: Non called listeners, with *more* stuff
you can hook into? Wait, why aren't they called? Like hooks, not all events happen
on every request. Like this one - `routing.route_finished`: it's only called when
the routing cache is built. And if you wanted to hook into the route-building process,
you could attach a listener to this.
