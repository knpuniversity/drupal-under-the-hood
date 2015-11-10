# Debugging!

Debugging in Drupal 8 is pretty sweet... if you now the tools to use.

## Turning on Debugging

First, let's activate a debug mode so we can see errors... *just* in case some *other*
developer makes a mistake and we have to debug it.

In `sites/` there's an `example.settings.local.php` file that can be used to activate
development settings locally. In the terminal, copy this to `sites/default/settings.local.php`.
I'm using sudo because I don't have write permissions to some of these files. I don't
like that, so use `sudo chmod 755` on that file. Do the same to `settings.php` and
the whole `sites/default` directory:

```bash
sudo cp sites/example.settings.local.php sites/default/settings.local.php
sudo chmod 755 sites/default/settings.local.php
sudo chmod 755 sites/default/settings.php
sudo chmod 755 sites/default
```

The `settings.local.php` actiates several things that are good for debugging, like
a `verbose` error level. It also loads a `development.services.yml` file that we're
going to talk about soon. But jsut having `settings.local.php` isn't enough! Open
`settings.php`. At the bottom, uncomment out the lines so that this file is loaded.

Of course, we need to rebuild our cache and the Drupal Console in all its wisdom
has a command for that: `cache:rebuild`:

```bash
drupal cache:rebuild
```

From this command you can clear all kinds of different caches, like the `menu` cache,
`render` cache or leave it blank to do everything.

Side note: the Drupal Console app is built on top of the Symfony Console library,
and you can take advantage of it to create really cool command line scripts like
this if you want to. It's one of the *best* pieces of Symfony.

Back in the browser, if you refresh now, there's no difference: everything is roaring
along. But, try deleting `roar()` function and refresh. Now we get a nice error that
says:

> The controller for URI /the/dino/says/50 is not callable.

That's a way of saying "Yo! This route is pointing to a function that doesn't exist!"
And when we put the function back and refresh, things are back to a roaring good time.

## List *all* the Routes

*Every* page of the site - including the homepage and admin areas - has a route.
And that leads me to the next natural question: what time is dinner? I mean, can I
get a list of every single route in the system? Well, of course! And dinner is at 6.

Once again, go back to the trusty Drupal Console app. To list *every* route, run
`router:debug`:

```bash
drupal router:debug
```

Wow! This prints *every* single route in the system, which is *wonderful* when you're
trying to figure out what's going on in a project. This includes the admin route
and our custom route.

To get more information about a route, copy it's internal name - that's the part
on the left - and pass it as the second argument to `router:debug`. The route has
several curly brance routing wildcards that are passed to the `getForm` method of
this controller class. This is pretty sweet, but we can go further!
