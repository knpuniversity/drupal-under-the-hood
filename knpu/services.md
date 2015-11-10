# Services

The first half of learning Symfony involves understanding that every page has a route
which contains the URL and points to a controller which is just a function that we write
that builds the page. So far, a controller always returns a response object. Later, we'll
return something else when we want to use the views and theming systems. For now, your controller
returns a response object.

The second half of learning Symfony is all about these things called services. This is a term
you will hear a lot and people love to describe it in a very scary way. Service, is a word 
for a useful object -- not so scary, right? It's some class that you or someone else creates that
does some work for you. 

If you have a logger class, that's called a service because you can call a function on it and that
will log a message. Or say you have another class called a mailer that sends emails, that's a service!
So what's an example of a class that doesn't do anything? Multivariable Calculus -- jk I studied math
in college, and I use what I learned in that class to calculate the tip on restaurant bills. Totally 
worth it. But really, a class that doesn't do anything could be a node class, an entity class. One that
doesn't really do work, instead it stores data.

Along with this is the idea of a service container or dependency injection container which is another one
of our favorite phrases to use when we want to sound really scary. 

In Drupal and Symfony, there is a single object called the container. It is basically an associative array
of services. It holds all of the useful objects in the system and each is given a nickname. When you want
to fetch that service out of the system then you ask the container "Hello! Can I get the service who's
nickname is logger.factory, please". 

We have a bunch of useful objects and a container to hold them all. The really cool thing about Drupal is 
that you will find that everything is done by a service. The execution of the routing, the handling of the
cache, the reading of configuration. These aren't done by Drupal core, they are done by a service and you
have access to use any of these services at any time. You even have access to override and replace the core
services if you want to. 

The most important part of the new way of doing things in Drupal 8 centers around the services and the 
service container that holds them. 

Ok back into the code, here in the `roarController` we take an account variable and then we make a roar that
is either `roar` or `rooooooar` depending on how long the count is. 

Suppose that this line here is actualy something very complicated. Maybe it took 50 lines of code. We could
have 50 lines in our controller, the downside of that is it makes our controller function difficult to read.
And any code that you put in your controller function is not reusable elsewhere. 

Instead, take this code and put it somewhere else. Some other class that you create that Drupal doesn't care
about to help organize your code. In my `src` directory I'll create a new directory called `jurassic`, the
name you give this doesn't matter. And inside of this new directory create a php class called `RoarGenerator`.

Just like with controllers, every single class in the `src` directory needs to have a namespace that follows the
standard of `Drupal\` module name `\` whatever directory or directories that you're in. In this case we're just in
one subdirectory called `jurassic`. And then the class name matches the file name `RoarGenerator`. 

This class has nothing to do with Drupal, it's just our class so it doesn't need to extend anything. And we can
make it do whatever we want. Create a `public function getRoar()` which will take a `$length` argument. Head over
to `RoarController` and copy the code that creates that. Replace `$count` with `$length` and return that value. 

Great! Now we have our imaginary complex code moved elsewhere. How do we create this? Good news, it's quite easy!

Start with a `$roarGenerator` in your controller and set it `= new RoarGenerator();` and when I hit the tab key
there it autocompleted my line and added the use statement up top. Below that line update what we have to be
`$roar = $roarGenerator->getRoar();` and pass it `$count`. 

Nothing special going on here, we're just moving our logic to an outside class, then instantiating that object
and calling a method on it. Because our namespace is following this pattern here we don't need to worry about
require statements, that class is going ot be automatically found. We can just use it. 

This has nothing to do with Drupal or Symfony, it's just good object oriented code. Let's give it a shot!

Back in the browser navigate to localhost:8000/the/dino/says/50 and we see the scary roar meaning everything
works just fine. 

Now we're ready to talk about that service container thing. Head over to the terminal and run Drupal Console's
task `container:debug`. This prints out every single service in the container. This huge list here is all of them.
On the left you have the nickname of the service which is what you'll use if you want to use that service. On
the right it tells you what type of object you are going to get out. 

Most of the services here you won't use directly but you do see some like cron, database which is the database
connection, file_system and a few other ones that you will use.

Before we get into how to use these in your controller and other places, I want to put our `roarGenerator` 
into the service container. What that means is that instead of instantiating it directly, we'll teach
Drupal's container how to instantiate the `roarGenerator`. Then we'll ask the container for it and the
container will make it for us.

Why would you do this? Hold on, you'll see the benefits shortly. To register a service, at the root of your
module create a `dino_roar.services.yml` file. Inside of this file start with a `services` key. For the service
container to create a `roarGenerator` for us it needs to know two things: what's your spirit animal and your
favorite color. I mean, first the nickname of our service and this can be anything, I'll keep with our theme
and use `dino_roar.roar_generator`. You want this to be short but somewhat unique and all lowercase alphanumeric
characters with exceptions for `_` and `.`.  

