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
