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

The second thing the container needs to know is what is the class. To do that just add a class key and type
`RoarGenerator`, I'll hit tab to have it autocomplete because we need the fully qualified namespace here.
There we go! 

Over in the terminal rebuild the cache. Now run `container:debug` and pipe it into grep for dino, and we can
see that there is a new service in the container whose nickname is `dino_roar.roar_generator` and it gives
us back this class. So, great how do we actually use that inside of the controller? Here's the key
In the IDE notice that our controller class isn't extending anything, it doesn't need to but usually
it will extend a class called `ControllerBase` and when I hit tab the use statement is added for me. This
has a number of shortcut methods in it which we'll take a look at. It also has the ability to get services
out of the container. 

Use the shortcut `command+n` select override from the menu and override the create function that's in the
base class. You don't need to use PhpStorm override to do that, it's just a nice shortcut to create this
function and it added the use statement for the `ContainerInterface` when I did it. When your controller
needs access to services this is the way you do it. 

We added a static create function and now when Drupal instantiates your controller it calls this function
to do that and passes you that `$container`. The container has one method on it that's important which is
`get`. That gets a service out of the container. So type `$container->get('');` and pass it `dino_roar.roar_generator`.
Behind the scenes Drupal instantiates that object, and pass it to us. Now `return new static();` and pass
it the `$roarGenerator`. This may look weird to you at first but stay with me. The new static says "create
a new instance of `RoarController` and return it, please". 

Now that is done, create a `public function __construct()` because we're passing this `RoarController` a
`$roarGenerator`. So up here say `RoarGenerator $roarGenerator` as an argument. I added a typehint, which is
nice but it is optional. 

Create a `private $roarGenerator` property and set it with `$this->roarGenerator = $roarGenerator;`. This
is kind of a big step here. The minute that you extend `ControllerBase` and you have a `public static function create`
instead of Drupal instantiating your `RoarController` for you it calls this create function. This means we
can say `new static` which is the same as saying `new RoarController` and we can pass in any arguments we 
want to the construct function of this class. That's really handy since we're passed the container here 
we can fetch out any services out of the container that we want and then pass those to ourselves. 

In the construct function we don't use them yet, we just set them as properties on ourselves which saves them
for use later. Then, 5, 10, 20 or 100 miliseconds later when Drupal finally calls the `roar` function we know
that this `roarGenerator` property is already set which means we can delete the `new RoarGenerator` line and
instead use `$this->roarGenerator` directly. 

Phew! Moment of truth, head back to the browser change the URL and hit enter to reload the page. Hey! It still
works! 

The big difference is that we are not creating the `roarGenerator` anymore, instead the container is doing it.
We've used this pattern to ask the container politely for our service.

Why did we go to all this trouble? Two reasons. First, I keep describing the container as an array of all of
the useful objects in the system, but that's not entirely true. It is an array of potential useful objects.
It doesn't instantiate the objects until and unless we ask for them. So, until we actually have this line 
here that asks for the `roarGenerator` it doesn't use the memory to instantiate that. 

By putting things in the service container which means registering it as a service, it allows us to have all
of these useful tools but we don't worry about losing memory until someone asks for that service. If during 
one request multiple parts of our code as for the `dino_roar.roar_generator` it's going to return them the 
same instance. Meaning it will only create it once. That is awesome because you might need a `roarGenerator` 
in 50 places and you don't want to create 50 roar generators because that would waste memory. Built in to the 
container is the fact that you don't have to worry about that, you just ask for the service and it creates it 
once or gives you back the service if it already has it. This is one of the reasons that Drupal and Symfony are 
able to be as fast as they are.

The second reason will be more apparent in a moment, it has to do with constructor arguments in the `roarGenerator`.
Here we can just ask for the `roarGenerator` and we don't really care if it has constructor arguments or not, it
just creates it for us. If that doesn't make sense yet, no problem we'll cover it in a moment.

Now that we have this pattern of the create function passing into our constructor, it means that we can use any
service in the container very easily. 

Go back to the terminal and run `container:debug` and grep for log, we'll find that there is a service in container
called `logger.factory` which is one of the ways that you can log things in the system. Well, let's get to logging!
In `RoarController.php` type `$loggerFactory = $container->get('logger.factory');` and pass that as a second
constructor argument to our controller.

In the terminal we can see that this is an instance of `LoggerChannelFactory`, so if you want to add typehinting
that's what you should use. In the autocomplete suggestions there is a `LoggerChannelFactory` and `LoggerChannelFactoryInterface`, that's pretty common. It would be correct to use `LoggerChannelFactory` but if you
look inside of that you'll see that it implements the interface. Interfaces are a bit more advanced, so to keep
it simple you can stay with that since that is what we saw in the container. But, if you want to go a little
further you can use the interface version. 

Call the `$loggerFactory` argument and I'll use a PhpStorm shortcut called "initialize fields" to add that argument
for me. If you want to dive into PhpStorm shortcuts we have a full tutorial on that, it will speed up your development.

In the `roar` function we can use that the same way. `$this->loggerFactory->get('')` which gets the channel for the logger
and if we peek into the terminal we can see that there is one called `default`. Then add `->debug();` and pass it
`$roar`. We are now using our first service out of the container. Back to the browser and refresh.

That should have put something into our logs, let's head over to a page where I can see our main menu, click into
reports, go into recent log messages and there it is! 

Not only did we add our own service to the container, but we saw how in our controller we can get access to any
service in the system. Considering how many there are, that makes you very dangerous. 
