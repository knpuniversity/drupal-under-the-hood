# Installation, Composer and Git!

Hello Drupal people! I'm Ryan, and I come from the magical world of Symfony, full
of gumdrops, rainbows, interfaces, services, dependency injection and lollipops.
Along with a few other oompa loompas, I lead the Symfony documentation team, so I
may not seem like the most obvious person to be teaching you about Drupal 8. But
Drupal 8 has taken a *huge* leap forward by using common coding patterns and libraries.
This makes Drupal a lot easier and more accessible to a lot of people.

This series is meant for developers who have used Drupal before. Instead of learning
how to use it, we're going to rip apart the layers and see how this machine runs.
That's going to make you more dangerous and uncover possibilities you wouldn't otherwise
know about.

## Download D8

Start by downloading Drupal 8, which at this moment isn't quite released, but it will
*very* soon! This unzips the file to my `Downloads` directory. I'll move it to a
`drupal8` directory. We can see all of our shiny new files here in my shiny
PhpStorm editor.

## The Built-in PHP Web Server

Move into the `drupal8` directory. We need a webserver! But I'm not going waste time
setting up Apache or Nginx locally. Instead, I'll use the built-in PHP web server.
Start it by running `php -S localhost:8000`:

```bash
php -S localhost:8000
```

This serves files from *this* directory
and will hang there until you stop it. I highly recommend using this to develop.

In the browser, navigate to `http://localhost:8000`. Hello Drupal 8 install screen!
Pick the standard installation to get a few more features.

## Fixing php.ini problems

On the next step, I have a problem: the `xdebug.max_nesting_level` setting in php.ini
is set too low. Wah wah.

Bah, it's easy to fix. Go back to the terminal and open a new tab. Run `php --ini`:

```bash
php --ini
```

This will tell you *where* the `php.ini` file lives. Open it with your favorite editor.
I like `vim`, because it gives me street cred.

***TIP
In some setups (specifically OSX), there will be *no* value for "Loaded Configuration File".
Usually, there *is* a file in the "Configuration File (php.ini) Path" directory,
but it's named something like `php.ini.development`. Rename this file to `php.ini`
and run `php --ini` again.
***

Search for the setting! It already exists in my file, so I'll set it to 256. If it
doesn't exist in your file, just add at the bottom. For this change to take effect,
restart your web server. For us, hit `control+c` to kill the PHP web server and then
start it again.

That fixes it! Type in your database details: I'll call my database `d8_under_hood`
and pass `root` with no password for my super secure local computer.

Now go grab some coffee or a sandwich while Drupal does it's installation thing. 

Ding! Give your site a clever name and an email address. Um, but enter *your* email,
not mine. The super-secret and secure password I'm using is `admin`. Select your country
and hit save.

Phew! I mean congrats! You now have a working Drupal 8 site!

## Storing in Git and Composer

You know what I love most about a new project? Creating a new git repo. Seriously,
how often do you get to type `git init`?

```bash
git init
```

In PhpStorm, you can see an `example.gitignore` file. Refactor-Rename that to `.gitignore`.
Open it and uncomment out the `vendor` line to ignore that directory. The project
also has `composer.json` and `composer.lock` files. Composer is PHP's package manager,
and it has changed *everything* in our world. If you aren't familiar with it, go
watch our [Composer tutorial](http://knpuniversity.com/screencast/composer)!
Seriously, you can use it in Drupal 7...we do in that tutorial...

Because of the `composer.json` file, you should *not* need to commit the `vendor/`
directory. You should also not need to commit the `core/` directory where all of
Drupal lives, due to some special Composer setup in Drupal. Another developer should
be able to clone the project, run `composer install` and both `vendor/` and `core/`
will be downloaded for them.

When I tried to do that, I had a little trouble with the `core/` directory due to
an autoloading quirk. Hey, it's not released yet, so there could be a bug. It's cool.

In another screencast, I'll show you the proper way to use Composer with Drupal.
But for now it's safe to *not* commit the `vendor/` directory at least. If you run
`composer install`, it'll populate that directory correctly.

Zip back over to the terminal and run `git add .` and then `git status`. There are
a lot of files in `core/`, so it *will* be nice to not have to commit those someday.
But other than these `core/` files, we're not committing much. A new Drupal "project"
doesn't contain many files.

Finish this by typing `git commit` and typing in a clever commit message for your
fellow contributors to enjoy. Done!

## Please, Please use a Decent Editor

I have a secret to tell you that will make your Drupal 8 experience many times better:
use a decent editor, the best is PhpStorm. Atom and Sublime are also pretty good.
But if you use Notepad++ or open some directory explorer to dig for files manually,
there will be *no* rainbows, Pixy Sticks or Gumball drops in your Drupal 8 experience.
Your editor must be able to auto-complete, have a directory tree and have a keyboard
shortcut to open files by filename. Ok, I've warned you!

## PhpStorm Symfony Plugin = Joy

If you *do* use PhpStorm... which would make you my best friend... it has a Symfony
plugin that plays nicely with Drupal too. Score! In Preferences, under plugins, click
browse repositories and search for "Symfony". You'll find this awesome Symfony plugin
that has over 1.3 million downloads! If you don't have this installed yet, do it.
I already have it. After installing, it'll ask you to restart PhpStorm. Once it's
open again, head back to Preferences, search for Symfony, and you'll find a new
Symfony plugin menu. Make sure you check the `Enable Plugin for this project` box.
Remember to check this for each new project.

This plugin will give you some pretty sweet autocompletion that's specific to Drupal
and Symfony.

Sweet! We're up and running! Let's get into the code!
