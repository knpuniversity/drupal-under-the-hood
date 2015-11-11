# Configuring a New Service

The service container is the magician's hat of Drupal: it's full of useful objects,
I mean "services" - we're trying to sound sophisticated. By default, the container
is *filled* will cool stuff, like a logger fatory, a translator, a white rabbit and
a database connection, just to name a few.

## List All Services

Head over to the terminal and run a new Drupal Console command:

```bash
php app/console container:debug
```

This prints *every single service in the container*: over 400 tools that we have
access to out-of-the-box. The nickname of each service is on the left: you'll use
that to get that service. On the right, it tells you what type of object this will
be.

Most of the services here you won't need to use directly: some like `cron`, `database`
`file_system` and a few other ones might be *really* useful to you.

## The module_name.services.yml File

Before we get into how to use these services, I want to add our `RoarGenerator` to
the service container. This means that instead of instantiating it directly, we'll
teach Drupal's container how to instantiate the `RoarGenerator` for us. Then we'll
ask the container for the "roar generator" and it will create it for us.

Why would you do this? Hold that thought: you'll see the benefits soon.

To register a service, go to the root of your module and create a `dino_roar.services.yml`
file. Inside, start with a `services` key. In order for the container to create the
`RoarGenerator` for us, it needs to know two things: what's your spirit animal and
your favorite color.

Scratch that: the first thing it needs to know is what "nickname" to use for the
service. This can be anything, how about `dino_roar.roar_generator`. The only rule
is that this needs to be unique in your project and use lowercase and alphanumeric
characters with exceptions for `_` and `.`.

The second thing the container needs to know is class for the service. To tell it,
add a `class` key below the nickname and type `RoarGenerator`. I'll hit tab because
I'm *super* lazy and PhpStorm isn't. It gives me the fully qualified namespace. Thanks
Storm!

Go to the terminal and rebuild the cache:

```
drupal cache:rebuild
```

*Now* run `container:debug` and pipe it into grep for "dino". There it is! It's nickname
is `dino_roar.roar_generator` and it'll give us a `RoarGenerator` object. Yay! Um,
but what now? How can we get that service from the container? Actually, I have no
idea. I'm kidding - next chapter!
