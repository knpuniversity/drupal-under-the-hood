# Modules, Routes and Controllers

## Creating a Module

Let's do something fun, like create a custom page. Like always, any custom code will
live in a module. And modules live in the `modules/` directory. Create a new one
called `dino_roar`. To make Drupal fall in love with your module, create the info
file: `dino_roar.info.yml`. If you loved the old `.info` files, then you'll feel
all warmy and fuzzy with these: it's the same thing, but now in the YAML format.

Inside give it a `name`: `Dino ROAR`, a `type`: `module`, `description`: `Roar at you`,
`package`: `Sample` and `core`: `8.x`. If YAML is new to you, cool! It's pretty
underwhelming: just a colon separated key-value pair. But make sure you have at least
one space after the colon. Yaml also supports hierarchies of data via indentation -
but there's none of that in this file.

Module ready! Head back to the browser and go into the "Extend" section. With any
we'll see the module here. There it is under "Sample": "Dino ROAR". It sounds terrifying.
Check the box and press the install button anyways. What's the worst that could
happen?

Nothing! But now we can build that page I keep talking about.

## Add a Route

In any modern framework - and I *am* including Drupal in this category, yay! - creating
a page is two steps. First, define the URL for the page via a *route*. That's your
first buzzword in case you're writing things down.

Second, create a *controller* for that page. This is a function that you'll write
that actually builds the page. It's also another buzzword: controller.

If these are new buzzwords for you, that's ok - they're just a new spin on some old
ideas.

For step 1, create a new file in the module: `dino_roar.routing.yml`. Create a new
route called `dino_says`: this is the internal name of the route and it isn't important
yet. Go in 4 spaces - or 2 spaces, it doesn't matter, just be consistent - and add
a new property to this route called `path`. Set it to `/the/dino/says`: the URL to
the new page.

Below `path`, a few more route properties are needed. The first, is `defaults`, with
a `_controller` key beneath it. The `_controller` key tells Drupal which *function*
should be called when someone goes to the URL for this exciting page. Set this to 
`Drupal\dino_roar\Controller\RoarController::roar`. This is a namespaced class followed
by `::` and then a method name. We'll create this function in a second.

Also add a `requirements` key with a `_permission` key set to `access content`. We
won't talk about permissions now, but this is what will allow us to view the page.

In YAML, you usually don't *need* quotes, except in some edge cases with special
characters. But it's always safe to surround values with quotes. So if you're in
doubt, use quotes! I don't need them around `access content`... but it makes me feel.

## Add a Controller Function

Step 1 complete: we have a route. For Step 2, we need to create the controller: the
function that will actually build the page. Inside of the `dino_roar` module create
an `src` directory and then a `Controller` directory inside of that. Finally, add
a new Php class called `RoarController`.

Ok, stop! Fun fact: *every* class you create will have a namespace at the top. If
you're not comfortable with namespaces, they're really easy. So easy that we teach
them to you in 120 seconds in our 
[namespaces tutorial](http://knpuniversity.com/screencast/php-namespaces-in-120-seconds).
So pause this video, check that out and then everything we're about to do will seem
much more awesome.

But you can't just set the namespace to *any* old thing: there are rules. It must
start with `Drupal\`, then the name of the module - `dino_roar\`, then whatever directory
or directories this file lives in after `src/`. This class lives in `Controller`.
Your class name also has to match the filename, + `.php`. If you mess any of this
up, Drupal isn't going to be able to find your class.

The full class name is now `Drupal\dino_roar\Controller\RoarController`. Hey, this
conveniently matches the `_controller` of our route!

In `RoarController`, add the new `public function roar()`. Now, you might be asking
yourself what a controller function like this should return. And to that I say -
excellent question! Brilliant! A controller should *always* return a Symfony Response
object. Ok, that's not 100% true - but let me lie for just a *little* bit longer.

To return a response, say `return new Response()`. I'll let it autocomplete the
`Response` class from Symfony's HttpFoundation namespace. When I hit tab to select this,
PhpStorm adds the `use` statement to the top of the class automatically. That's important:
whenever you reference a class, you *must* add a `use` statement for it. If you forget,
you'll get the famous "Class Not Found" error.

For the page content, we will of course `ROOOAR!`.

That's it! That's everything. Go to your browser and head to `/the/dino/says`:

> http://localhost:8000/the/dino/says

Hmm page not found. As a seasoned Drupal developer, you may be wonder, "uhh do I
need to clear some cache?" You're right!
