# Debugging Webprofiler

One of the things that you're going to love most about working with Drupal 8
are the debugging tools, some of which are borrowed from Symfony. 

Let's start with something simple, in the sites directory we have an `example.settings.local`
file which we can use to activate development settings locally. 

Head over to the terminal and copy the `example.settings` file into `sites/default/settings.local.php`
I'm using sudo here because, at least on my machine, the file is write protected. Then `sudo chmod 755`
so you can actually write it. Change the write permissions on the `settings.php` file as well.

In our IDE we've got our new `settings.local.php` which I don't need to touch, and at the bottom of
the `settings.php` file uncomment out the if statement for the local settings file. Let's also
chmod 755 the directory itself. 
