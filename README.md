# Drupal 8 Under the Hood!

You're viewing the code - in all its glory for the
KnpUniversity Tutorial: [https://knpuniversity.com/screencast/drupal8-under-the-hood](Drupal 8: IUnder the Hood).

## Installation

We start this tutorial from scratch: by installing Drupal. But, you can get
this code up and running by doing the following:

**Download Composer dependencies**

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

**Setting up the Site & Database**

This code comes from a pre-built Drupal site, which means we've already
completed the installation process and have a database.

First, check that the database settings in `sites/default/settings.php`
are correct for your system.

Then, import the database dump - `finished_database.sql` - into your
database.

**Start the built-in web server**

You can use Nginx or Apache, but the built-in web server works
great:

```
php -S localhost:8000
```

Now check out the site at `http://localhost:8000`

Have fun!

