# Debugging Webprofiler

One of the things that you're going to love most about working with Drupal 8
are the debugging tools, some of which are borrowed from Symfony. 

Let's start with something simple, in the sites directory we have an `example.settings.local`
file which we can use to activate development settings locally. 

Head over to the terminal and copy the `example.settings` file into `sites/default/settings.local.php`
I'm using sudo here because, at least on my machine, the file is write protected. Then `sudo chmod 755`
so you can actually write it. Change the write permissions on the `settings.php` file as well.
And chmod our directory as well.

In our IDE we've got our new `settings.local.php` which I don't need to touch. It activates several
things that are good for debugging, like a `verbose` error level. This also loads a
`development.services.yml` file which we'll cover a bit later. Just having this file isn't enough!
You have to activate it at the bottom of the `settings.php` file by uncommenting out this if statement.
Yes, now it will load our `settings.local.php`!

Of course, to get this to work we need to run a cache clear and the Drupal Console in all its wisdom
has a command for that, `cache:rebuild`. From this command you can clear all kinds of different caches
inside of here if you know which one you want. I'll leave this set to all to clear all the caches.

By the way, the Drupal Console app is built on top of a Symfony component and you can take advantage of
the Symfony console component to create really cool command line scripts like this if you want to. 

Back in our browser if we refresh now there's no difference and everything is roaring as usual.
But, if I go in and delete our controller function and refresh we get a really nice error that says
"The controller for URI /the/dino/says/50 is not callable." Which is a way of saying "Yo! You're pointing
me at a function but I'm not actually finding it." And when we drop it back in there and refresh things
are back to a roaring good time.

Every page in our site, including the homepage and admin areas have a route. Which leads to the
next natural question, what time is dinner? I mean can I get a list of every single route in the system?
Well, of course! 

Once again, go back to the trusty Drupal Console app for this and run `router:debug` and this prints
out every single route in the system which is wonderful when you're trying to figure out what's going on.
This even includes all the admin and our custom routes. 

If you need more information about a route just copy it's name, that's the part on the left, and pass
it as a second argument to `router:debug`. The printout shows lots of curly braces in the route which
are passed to the `getForm` method of the controller class. That's pretty cool, but we should go further!

Google for Drupal Devel, it will lead you to a project on Drupal.org that has some pretty cool developer
tools in it. What we're after here is the web profiler. Copy the link address to it and let's install it.
In the future you should be able to install these modules via Composer. For now, press `install new module`,
paste the URL and press the install button.

Now that it's finished click the `enable newly added modules` link. From here, the only part that I'm interested
in is the web profiler. I'll click that and press the install button. It'll also ask me to install the devel
module which is fine, hit continue, watch closely.

The very next request has this really cool web debug toolbar at the bottom. This shows us tons of stuff like
database queries, who is authenticated, stats about the configuration, the css and js that's being loaded and
even the route and controller that's being modified for this page as well as the status code. 

Before we dive into all these details go back down on this page to the web profiler, expand it and go to 
configure. Here we see that there's even more information that you can display if you want to. In here,
go ahead and check events, routing and services then press the save configuration button.

Ooo look a few new things on the toolbar. Clicking any of the icons here will take you to a new page called the
profiler. The profiler is extra information beyond just the web debug toolbar. So, if you want to see all of
the routes you can click the routing tab and it will show all of the routes in the system, which is the
same output that we had through the Drupal Console app. 

There are lots of other cool treats in here as well, it's like Halloween! Like performance timing, which checks
how fast the front end of your site performs. The timeline is another really cool area, which for some reason
in this version of the console is not rendering right now. It normally shows you how long it takes your PHP
code to execute, it's one of my favorite parts of the profiler. 

If you follow the documentation for installing this you also need to install a couple of javascript libraries
to help the profiler do its job, but it works pretty well without them and I skipped that part so I could
show you the cool stuff in here as quickly as possible.

Now that we have this, if we click on the admin structure page which is given to us by Drupal you might not know
how it works. But if you go down to the toolbar and hover over the 200 status code you can see exactly which
controller this is coming from. If you see the `D\s\C` know that it stands for Drupal System Controller. The
web profiler is trying to shorten things so the class names don't look so long. Hovering over the short syntax
shows you exactly where it is. 

So that's `SystemController::systemAdminMenuBlockPage`, if you wanted to reverse engineer this you could! 
I'll use the keyboard shortcut `shift+shift` to to search the project for `systemcontroller` and this pulls
up that controller class. Now look around for the method `systemAdminMenuBlockPage`. This is the actual
function that renders this page. In fact, `return new Response('HI!')` from here instead of calling the function
to completely short circuit this page. 

We don't know yet what this system manager thing is or how to debug it, but it is where we are headed next. 

I just think it's really cool that we can easily see exactly what's going on in the page, dive into the core
code and find out how things work.
