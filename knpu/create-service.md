## Create a Service

In `RoarController`, we use the `$count` variable to construct either a little
`roar` or a big `rooooooar`, depending on what's in the URL:

[[[ code('05a1868311') ]]]

Let's use our imagination. Pretend that this line is actually quite complicated.
Maybe it takes 50 lines of code to figure this out! We could keep all 50 lines in
this controller, but that sucks: it makes this function hard to read. Oh, and any
code that lives in a controller can't be reused somewhere else. And don't even get
me started on unit testing...

It's time to grow up and move out of our parent's basement. I mean, it's time to
to organize this code and put it somewhere else: in a new class that's independent
of Drupal. In other words, in a *service*.

## Creating the Service Class

In `src/`, create a new directory called `Jurassic` - this directory could be called
anything - it's up to you to organize your services. Inside, create a new PHP class
called `RoarGenerator`:

This class, well *any* class, needs to have a namespace that follows the standard
of `Drupal\` module name `\` whatever directory or directories that you're in. This
class is in one subdirectory called `Jurassic`. And make sure the class name matches
the filename `RoarGenerator`:

[[[ code('3e511b7219') ]]]

This class has *nothing* to do with Drupal, it's completely our's. So you don't need
to make it extend any weird Drupal core class. *And* we can make it do whatever we
want. Create a `public function getRoar()` with a `$length` argument. Head over to
`RoarController` and copy the code that creates that. Replace `$count` with `$length`
and return that value:

[[[ code('d6a7d09a38') ]]]

## Using a Service (the long way)

Great! Now our imaginary, complex code lives somewhere else. How do we use it? It's
simple!

Create a  `$roarGenerator` variable and set it `new RoarGenerator();`:

[[[ code('074b8c8e82') ]]]

When I hit tab while typing the class, it auto-completes the line *and* adds the
`use` statement above the class. Do *not* forget your `use` statements people! You'll
get a "Class not found" error, and I'm pretty sure Dries gets a text message whenever
it happens. So you know, try not to make him angry: he's really tall.

After instantiating the `RoarGenerator` object, update the last line to
`$roar = $roarGenerator->getRoar();` and pass it `$count`:

[[[ code('66f73638ae') ]]]

There is *nothing* special going on here: we moved the logic to an outside class,
instantiated that object and then called a method on it. This has nothing to do with
Drupal or Symfony or Dries getting text messages: it's just good object oriented code.

Let's give it a shot!

Go back to the browser and navigate to `http://localhost:8000/the/dino/says/50`.
There's the scary roar meaning everything is working.

If you're thinking, "This seems like *not* a big deal - we're just moving code around".
You're *so* right. Now keep watching!
