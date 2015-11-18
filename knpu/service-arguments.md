# Service Arguments

We extended `ControllerBase` which gave us access to this create function workflow where
we can pass services to our own controller and then use them. So cool!

But, we also have access to a bunch of helper functions. For example, the `$keyvaluestore`.
In Drupal 8 there is a way that you can just have a key value store and you can back that with
a database or with redis, it allows you to put things somewhere and fetch them out. As soon as
you extend `ControllerBase` you can get a `$keyvaluestore` by typing `$this->keyValue()` and
that is a built in function on `ControllerBase` and you can pass it some collection string that
you want to search for. Let's try this out. `$keyValueStore->set('roar_string', $roar);`
So, that will put that roar string into our key value store.  So, we will go to the url, with 50 and it passes it there, that should be in the key value store. 

So, let’s try it out a command, roar equals and the key value store and you will say roar equals key value store arrow get roar string, hit refresh and it works.  And if I change that now to 500, it's pulling from the key value store, so it doesn’t change the length.  So, that’s really cool.  That’s the key value sore working in action.  But, what I am going to say is, what is the key value function here really doing. 

So, in peach be strong, if I hold command and click this, it will open controller base, or you can open by file name to find the controller base that’s in the core directory.  And look closely here, there is a function in controller base called container and that’s a short cut to go out and get the service container.  The same container that is passed to us in the create function.  So, this is the container and look what it does, it gets out a service called key value. 

So, this is the important thing, the key value store, is not some weird core part of Drupal, it is just a service called key value and that is how you access the nice key value store.  So, if you need to use the key value store somewhere else, you just need to get access to the key value service.  And that is exactly what I want to do inside of roar generator.  I want you to pretend like this calculation here of the length is taking a really long time, like 2 seconds.  So, we only want to calculate it once and then we want to put it in a key value store.  

So, we know now how to get access to services within our controller, we just use this create, by using this workflow where we inject the services.  In some cases, you don’t even need to do that, because there are some shortcut methods inside of controller base for some really common stuff.  Now how do we get access to the container inside of her?  Well, this idea of expanding controller base and having this create function, I will tell you right now, that is special to your controller.  

That will work nowhere else.  Inside of roar generator, which is a service, we are going to need to do something different.  We are going to do something slightly different that will look similar.  As soon as we need access to some service, were going to go to public function destruct, then we are going to pass it in as an argument.  Now, first, I’m going to Drupal consult container debug and grab that for key value, because I want to know what type of object that is. 

You can see that it is a key value factory. [Inaudible][00:04:12] because, I’m just going to type in that.  And once again, there is a key value concrete class and there is also key value factory with that implements, you can type in either of them, the interface is technically more correct, but it doesn’t really matter.  And we’ll say, key value factory is our argument and then we will open a function.  I will use another shortcut, its alt enter on mac in the initialize fields and again, that doesn’t do anything special, it just creates this private property for me and sets it.  

So, this is similar to what we did in our controller, in that, if we need something, we force it to be passed into the constructor.  So, if views in isolation, what we are saying here is, whoever creates the roar generator, they are going to be forced to pass in the key value factory.  Then, down here we can use it.  We don’t know who is going to instantiate us yet, but let’s not worry about that.  Let’s just start using our key value store down below.  So first I will create a cache key called roar underscore and then the length, use a different cache key for each thing.  

Then we will say, store equals this arrow key value factory arrow get.  Now we are saying dyno and if store has key, then we will just restore arrow get, get key.  This will save us from this really long sleep down here and at the bottom we will set the actual string to a variable and then say store arrow set key string and then return that.  So, as long as somebody passes the key value store, this class is going to be able to use it really easily. 
So, if we don’t do anything else, and we refresh, so try this.  Go into roar controller and common out the key value stuff, get rid of the key value stuff and just put back our original code that’s using our roar generator.  Now refresh and this is great, look it.  Call to member function, get on nole, roar generator line 22.  What this means is that this arrow key value factory was not set, was not passed into our construct function.  

If you think about it, who is constructing our roar generator?  Well, it’s actually Drupal’s container itself, because we registered as a service.  So, behind the scenes, when we ask for it down here, it’s being instantiated at that moment.  So, we somehow need to teach Drupal’s container that hey, when you instantiate roar generator, it has a constructor argument and I need you to go passed that constructor argument.  You do that with the arguments key. 

This is an array, so I can hit enter, go out four spaces, or two spaces is a little more common in the Drupal world.  In here, I want to tell a container to inject the key value service.  So, if I put the string key value here, what it going to do it’s actually going to [inaudible] [00:08:15] roar generate and literally pass the string key value.  We want it to pass the service key value.  So, the secret way to do that is with the at symbol.  This tells the container, when you say new roar generator, go and find the key value service and pass that in as the first constructor arguments.  

Of course, since we just did a configuration file we need to do a Drupal cache rebuild.  Let's go back, refresh and it takes a little bit long there, the first time because it's hitting the sleep. Now after that it's super-fast.  Make sure you use the 50, takes two seconds or so the first time or so, then hit refresh and it goes really fast.  So, this is another one of those really important concepts, which is, that when you are in a service and you need access to another service or a configuration value, you need to add a constructor argument for it.  

Then go in your services.yml file, and set an argument, and the at symbol is the way to tell the container I actually want to pass in the key value service.  So, this is really cool, because at this moment in the container, in the controller, when we ask for the dyno roar generator, it looks to see if the key value service is already instantiated.  If it isn’t, it creates that first and then passes it to the dyno roar, roar generator. 

So, no matter how complex it is to create this roar generator, all we need to, I our code, is just ask for the roar generator, and the service container takes care of all the complications of exactly how to instantiate that.  
