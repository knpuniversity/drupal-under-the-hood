# Modules, Routes and Controllers

Let's do something really fun, like create a custom page. And of course
any custom code we create is going to go into a module, just like in Drupal 7
development.

Our modules will live in the modules directory of course, create a new one
in there called `dino_roar`. The first thing you need to do next is create 
the info file, `dino_roar.info.yml`. This should remind you a lot of the former
info files in Drupal except this one is in a yaml format.

In here let's add name `Dino ROAR`, type `module`, description `Roar at you`,
package `Sample` and core `8.x`. If you're not familiar with yaml, all you 
just know that it is colon seperated key value pairs with a hierarchy. What
you don't see here, but in other yaml files you'll see tab indentation used
to make subkeys. But we're not worrying about that right now!

This is all we need for our new module, so let's go in to extend and with any
luck we should see it in our list here. Down near the bottom we have Sample
Dino ROAR. Go ahead and check that box and press the install button. 

This module doesn't do anything yet, so neither does our new Drupal site.
But now we can create our page. 

In any modern framework like Symfony or Drupal, creating a page is two steps.
First, you define the URL for the page, which we'll call a route. And second,
defining the controller for that page. This is a function that we'll write to
actually build the page. 

These might be new terms for Drupal, but you'll see that the implementation is
very similar to the familiar hook system.

In our `dino_roar` module create a new file `dino_roar.routing.yml`. This is our
step 1, defining the URL which will create the route. Create a new route called
`dino_says`, this is the internal name of the route and it isn't important yet. 
To this add a path key called `/the/dino/says` which will be the URL. 

Below the path a few more things are needed. First, is a `defaults` key with an
`_controller` key underneath it. The `_controller` key will point to the function
that should be called when someone goes to this exciting page. Set this to 
`Drupal\dino_roar\Controller\RoarController::roar`. This is a namespaced class name
:: and then a method name. We'll create that in a second. 

Below all of this add a `requirements` key with an `_permission` key with `access content`.
I won't go into permissions now, but know that this is what will allow us to view
the page. 

In yaml you usually don't need quotes, but we did add them around access content. You
don't need them there, but you will need them when you are working with special charaters.
If you're ever in doubt then just throw them in there. 

Step 1 complete! We've created the route. Step 2 is to create the controller, the function
that will actually build the page. Inside of the `dino_roar` module create an `src` directory.
Inside of `src` create a `controller` directory and finall a new php class called `RoarController`.

Nice, look at this fresh class! Give it a namespace, and that namespace has to be a very specific
thing. It has to start with Drupal\, the name of the module which is `dino_roar`, \ and then
whatever directory or directories that you're inside of src. In our case this is `Controller`.

Namespaces are critical to Drupal and fortunately they're really easy! So easy that we teach
them to you in 120 seconds in our namespace tutorial. Feel free to pause this video, check that
out and then we can keep going. Don't worry we'll wait for you.

The thing to note here is that the name of this class is now `Drupal\dino_roar\Controller\RoarController`.
That's its fully qualified name. Which conveniently matches what we have here in our routing file.
The second rule says that your namespace has to start with `Drupal\dino_roar` and then follow
the directory structure after that. Also, your class name has to be the same are your file name .php.
If you mess that up then Drupal isn't going to be able to find your class.

This standard isn't a Drupal specific thing, this is a modern PHP standard. So any modern PHP app you work
in you'll see this namespace pattern. 

Back over to the routing file, we'll call function `roar` so in `RoarController` make a new `public function roar`.
You might be asking what our function is going to return, and to that I say - excellent question!
It should return a Symfony response object, do that with `return new Response()` and I'll let it autocomplete 
the response class from Symfony's HTTPFoundation namespace. So when I hit tab to autocomplete PhpStorm
added the use statement right here for us. That's important because whenever you reference a class you
need a use statement for it -- to avoid headaches try not to forget that! Or use the autocomplete feature
in PhpStorm to have it done for you.

Inside of our function we will of course Roar!

That's it, we should be able to go to this URL and have it render this page. Head over to the browser and give
it a try! Hmm page not found. As a Drupal dev you may be thinking, uhh do I need to clear some cache? And you do!
Google for a new utility called Drupal Console, which is a fantastic console script that helps you debug. It is
really awesome and you should say thank you to [Jesus Olivas](https://twitter.com/jmolivas) for his work on it.

Download and install this by copying the curl statement and run that in your terminal. And now move it into a
bin directory so I can just now say `drupal` in the terminal and it brings up the Drupal Console. And if you
run `drupal list` it gives you all of the commands that you can run. There is a lot of really good stuff in here,
some of which we'll cover in this tutorial.

One of those things is `router:rebuild` which rebuilds the router cache. Run that, and it'll take about a second.
Now go back, refresh and congratulations you've just created your first custom page in Drupal 8.

This follows the exact same steps that you would take to create a page in Symfony, which is pretty cool!

Notice that it doesn't add any theming or anything like that. We are literally just creating this page. 
Later we'll get into how you tap into the theme system for Drupal 8. But, if you want to return just
a response you can do that and Drupal won't do anything magical. Hey, this could even be a JSON response if you
wanted it to be. 

There are lots of things you could do with routing, the most important thing you're going to see is the 
addition of wildcards. This means that now the URL /the/dino/says/something and that something is required. 
In our example we want it to be a number like 5, 10 or 50. 

When you have a routing wildcard like this that's surrounded by curly braces, you can suddenly have a `$count`
argument in your controller function. So, `{count}` here gets passed to `$count` there. So let's say that
`$roar = 'R'.str_repeat('0', $count).'AR!'` and we'll use that to make our roar message dynamic and we'll
pass that into our function. 

Since we just changed the routing we'll need to go and rebuild the routing cache. Note first that if I just
refresh this page it's a 404, because as I mentioned that routing wildcard is required. It has to be 
`\the\dino\says\` *something*, anything but blank. There are ways to make it optional, but the way we have it 
now does not allow for that. 

Let's add 10 to our URL and refresh, Rooooooar! Make it 50 and the roar gets longer. 

Woah, you now know half of the new stuff in Drupal 8. It's this routing/controller layer. Make a route,
then your controller, in the simplest cases, returns a response. 





