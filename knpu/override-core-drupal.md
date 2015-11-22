# Overriding Core Drupal

Now that the value we want to change is stored as a parameter, we can override it
*only* on the local machine. Let me show you how.

## development.services.yml to Change Local Behavior

Earlier, we created a `settings.local.php` file, which is itself loaded from `settings.php`.
This file loads a `development.services.yml` file. And that's the key: this file
gives us tremendous power: power to override services and parameters. These changes
will *only* affect our local environment... well, really, *any* environment where
you've chosen to create the `settings.local.php` file.

Hey, you know what we should do? Override the parameter! Copy the name and set it
to `false` With any luck, this will turn off the cache. Rebuild it:

```bash
drupal cache:rebuild
```

Refresh! OMG, it's *so* slow! Every time I refresh, it's slow. This is *awesome*.
I mean, not the slow part - but the fact that we can tweak behavior locally.

Parameters are the *number one* way that you control the behavior of core and third
party modules. In fact, check out the `core` directory - that's where Drupal lives!
And hey, look at that `core.services.yml` file!

All the really important, base services are defined here: they're defined *just*
like we define *our* services. That's really cool. Most of the services we see in
`container:debug` are coming from here.

## Site-Specific Services

At the top, it *also* has a `parameters` key with all kinds of parameters stored
under it. These are values that *you* can override to control core behavior for
your app. How? In `sites/default`, you already have a `default.services.yml`. If
you rename this to `services.yml`, Drupal will load it. That's thanks to a line
in `settings.php`... that's hiding from me... there it is! The config `container_yamls`.

Open up `default.services.yml`. Hey, `parameters`! In fact, these are the same parameters
we saw in `core.services.yml`. So everything is setup to allow you to easily control
many different parts of the system.

One of the settings under `twig.config` is called `debug`, and it's set to false.
I want to set this to true, to make theming easier. I could rename this file to
`services.yml` and change that value. But then when we deploy, debug would *still*
be true. No, this is a change that I only want to make *locally*. That's the job
of `development.services.yml`.

Add `twig.config` there with `debug` set to `true`. Cool, that should replace the
original value from `core.services.yml`. Let's clear some cache:

```bash
drupal cache:rebuild
```

Change the URL to the home page where Drupal is using Twig. It looks the same...
until you view the source. There it is: the source is now *filled* with HTML comments
that tell you exactly which templates each bit of markup comes from and how you can
override them. And with `debug` set to `true`, you won't have to rebuild your cache
after every template change: Drupal will do that automatically. 

This is great! By understanding a few concepts, we're overriding core features in
Drupal and actually understanding how it works. That's awesome!
