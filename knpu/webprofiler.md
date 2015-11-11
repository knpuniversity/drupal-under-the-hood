# The webprofiler

Google for "Drupal Devel": it will lead you to a project on Drupal.org that has some
nice tools in it. What *we're* after is the webprofiler module. Copy the installation
link address so we can install it! In the future, you should be able to install modules
via Composer. More on that later.

For now, click `install new module`, paste the URL, press the install button and
wait with great anticipation! When it finishes, follow the `enable newly added modules`
link. I'm only interested in the web profiler. Check its box and press the install
button. It'll also ask me to install the devel, module which is fine. Hit continue...
and watch closely.

### The Web Debug Toolbar

On the very next request a really cool web debug toolbar pops up at the bottom. This
is the oracle of information about the request that was just executed - in this case -
a request to this admin page. It shows us tons of stuff like database queries, who
is authenticated, stats about the configuration, the css and js that's being loaded,
the route and controller that's being used for this page and - somewhere in there -
I'm pretty sure it knows where my car keys are.

Before you go crazy with this, go back down on this page to the `webprofiler`. Expand
it and click "Configure". Here, you can see that there's even *more* information
that you can display if you want to. Check the boxes for Events, Routing and Services
and then press the "Save configuration" button.

### The Profiler

Ooo look: a few new things on the toolbar. If you click any icon, you'll go to a
new page called the profiler. It turns out that the web debug toolbar was just a
short summary of the information about the last request. The profiler has *tons*
more.

If you want to see all of the routes, click the Routing tab. This is the same list
that the Drupal console showed us.

There are lots of other treats in here: it's like a Drupal Halloween! For example,
Performance Timing checks how fast the frontend of your site is rendering. The timeline
is probably my *favorite*... and for some reason it's broken in this version. Wah wah.
It normally shows you this great graph of how long it takes each part of Drupal to
execute. It's great for profiling, but also great to see what all the magic layers
of Drupal are.

If you follow the documentation for the `webprofiler`, you also need to install a
couple of JavaScript libraries to help the profiler do its job. But it seems to work
pretty well without them, so I skipped that part to save us time.

## Reverse Engineering an Admin Page

Now that we have this, click on the admin "Structure" page. Obviously, this page comes
from Drupal. But how does it work? Go down to the toolbar and hover over the 200
status code. Ha! This tells us exactly what controller renders this page. If you
see the `D\s\C` stuff, that stands for `Drupal\System\Controller`. The web profiler
tries to shorten things: just Hover over this syntax to see the full class name.

If you wanted to reverse engineer this page, you could! I'll use the keyboard shortcut
`shift+shift` to search the project for `SystemController`. Here's the class! Now,
look around for the method `systemAdminMenuBlockPage()`. And *this* is the actual
function that renders the admin "Structure" page. In fact, if you add `return new Response('HI!')`
and refresh, it'll completely replace the page! Try this and see if your co-workers
can figure out what's going on!

We don't know *yet* what this `systemManager` thing is or how to debug it, but we're
going there next.

I just think it's really cool that we can see exactly what's going on in the page,
dive into the core code and find out how things work.
