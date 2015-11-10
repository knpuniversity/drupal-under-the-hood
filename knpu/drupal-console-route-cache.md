# The Drupal Console & Route Cache

## The Drupal Console!

Google for a new utility called "Drupal Console". This is a *fantastic* console script
that helps you debug, clear cache and generate code. If you love it, you should say
thank you to [Jesus Olivas](https://twitter.com/jmolivas) and others for their work!
It's a bit like Drush, but different, but kind of the same... I don't know. They
seem to be co-existing and don't do the exact same things.

To download it, copy the curl statement and run that in your terminal. Next, move
it into a global `bin` directory so that you can simply type `drupal` from anywhere
in the terminal:

```bash
curl -LSs http://drupalconsole.com/installer | php
mv console.phar /usr/local/bin/drupal
drupal
```

***TIP
If you're on windows, use the `readfile` line and don't worry about moving the file
into a `bin/` directory. Instead, you can type `php drupal.phar` to run the `drupal.phar`
file that is downloaded.
***

Hello Drupal Console! Now try `drupal list`:

```bash
drupal list
```

This shows a *huge* list of all of the commands you can run. There is a lot of really
good stuff in here - we'll cover some of these in this tutorial.

### Clearing the Routing Cache

One of those commands is `router:rebuild`. Run that to clear the routing cache:

```bash
drupal router:rebuild
```

Ok, go back, refresh and congratulations!!! Seriously: you've just created your first
custom page in Drupal 8. By the way, creating a page in the Symfony framework looks
almost exactly the same. You're mastering two tools at once! You deserve a vacation.

Notice this page is *literally* only the text "ROOOOAR". It doesn't have any theming
or templates applied to it. We *will* tap into the theme system later, but this is
really interesting: if you want to return a `Response` all by yourself, you can
do that and Drupal won't mess with it. Hey, this could even be a JSON response for
an API. Drupal is a CMS, but it's also a modern, custom-development framework.
