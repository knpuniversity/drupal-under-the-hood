# Installation

Hello Drupal people! I'm Ryan, and I come from the world of Symfony. I work
on the Symfony core documentation team, which may not seem like the most obvious
person to be teaching you about Drupal 8, but as you're going to see, Drupal 8
and Symfony have a lot in common. 

This series is meant for developers who have worked with Drupal before. This tutorial
isn't about how to use Drupal, but how to use Drupal 8, how it works and how to get
under the hood to pull apart the pieces to see what's really going on. 

Download Drupal 8, which at this moment isn't quite released, but it will be in one
short week!

This unzips it to my downloads directory, and I'll move it over to a `drupal8` directory.
And we can see all of our shiny new files here in my editor, which is PhpStorm. 


Move into our new `drupal8` directory and now that we're here we're going to need a webserver. 
I'm not going to use apache or nginx because I'm just doing stuff locally, so I'll use the 
built in php web server. Which we start with `php -S localhost:8000`. I highly recommend using 
this in your development environmnent. 

Over in the browser navigate to localhost:8000, and there is the Drupal 8 install screen! 
So far so good. We'll go through this part quickly, pick the standard installation to
get a few more features. On the next step it looks like I have a requirements problem with
my xdebug. It wants me to set that to 256, that's pretty easy to do. Back in the terminal 
open a new tab and run `php --ini` because that tells me where my php.ini file lives.
Then I'll open that using vim, but you can use whatever you want to open it. 

Search in this file for that setting, it's already in my file so I'll set it to 256
but if you find you don't have it just add the whole setting at the bottom. To make
this change take affect I'll `control+c` out of the web server and start it up again. 
Now we should be good to keep going. Great! Database configuration. 

Type in your database credentials, my database is called `d8_under_hood` and for the username
I use root with no password because that's how my machine is setup. 

Now go grab some coffee or a sandwhich while Drupal does it's installation thing. 

Alright! On to configuring the actual site. Start with a clever name and an email address. Ideally
you will pick something other than my email. And of course a really strong password, I'll pick
admin/admin. To wrap up the form I'll go ahead and select my country and hit save. 

Congratulations! You now have a working Drupal 8 site! Let's get this thing stored in git immediately.
No time like the present for version control! 

Back over in the terminal run `git init` to initialize the repo. Over in our IDE we can see that there
is a `example.gitignore` file. I'll refactor/rename that to just `.gitignore`, open it up and uncomment
out the vendor line, we definitely want that to be ignored. 

We also have `composer.json` and `composer.lock` files. Composer is PHP's package manager, if you 
aren't familiar with it we have a full tutorial on it that I encourage you to go watch.

Technically, with this `composer.json` file you should not need to commit the vendor or core directories.
Another developer should be able to arrive, run `composer install` and bot vendor and core should be 
downloaded for them. 

When I tried to do that I had a little trouble with the core director and autoloading, so I think 
there might be a small bug there. But, we'll still cover the proper way to use composer in the future
with Drupal. For now it's safe to not commit the vendor directory since it will install correctly when 
you run `composer install`. 

Zip back over to the terminal and run `git add .` and then `git status`, there are a lot of core files,
so it will be nice to not have to commit them to the repo eventually. Other than these core files, there
aren't many that we are committing to our project just after install. That is awesome!

Now run `git commit` and type in a clever commit message for your fellow contributors to enjoy, and we're
good!

One more thing I want to emphasize is the importance of using a good editor when you are developing. We
have Namespaces in PHP and other things that you are not going to want to write yourself. The best editor
to do this for you is PhpStorm. Other good ones include Atom and Sublime Text, but I do prefer PhpStorm. 

In this IDE there's a Symfony plugin which works really nicely for Drupal as well. Score! Down under plugins,
head to browse repositories, search for Symfony. You'll find this awesome Symfony plugin down here that has
1.3 million downloads. If you don't have this installed yet, do it. I already have it and I'm not going to
update it. If you're installing it fresh you'll need to restart PhpStorm, and then head back into Preferences,
plugins and this time when you search Symfony, there will be a new symfony plugin menu in the tree there 
and you will need to check `Enable Plugin for this project`. 

Doing this will give you some really nice autocompletion that's specific to Drupal and Symfony.

Sweet, we're up and running! Let's get into the actual code!
