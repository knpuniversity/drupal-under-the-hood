## The Render Array... and Event Listeners

While we're on the topic, the render array works via a listener. When I told you
earlier that
[a controller *always* returns a Response object](https://knpuniversity.com/screencast/drupal8-under-the-hood/modules-routes-controllers#a-controller-returns-a-response),
that was a bloody lie! Return an array instead, and set `#title` to `$roar`.

Head to `/the/dino/says/50` in the browser. As expected, here is a fully-themed page.
And I say "as expected", but is it expected? One of the cardinal rules of a Symfony
controller is that it must return a Symfony `Response` object. But this is most certainly
*not* a `Response`: it's an array.

In truth, there's an exception to that rule: if you don't return an array, Drupal,
well, Symfony, dispatches an event called `kernel.view`. There it is! It runs *after*
the controller and has one job: try to convert the controller return value into a
Response.

Check out this `MainContentViewSubscriber`. Surprise! This is the listener responsible
for handling the render array, via its `onViewRenderArray()` method. I *love* how
the magic of Drupal gets more transparency via events.

So if you want to see how the render array system works, you just need to open that
class. In fact, I'll give you a little preview. Find `core.services.yml` again. Inside,
there's a section that includes some services, `main_content_renderer_html` and
`main_content_renderer_ajax`.  

If you looked into `MainContentViewSubscriber` far enough, you'd see it uses these
classes behind the scenes to figure out *how* to render the page. What's really
interesting - at least for me, admittedly, I *love* this stuff - is this tag:
`main_content_renderer` with `format: html`. The AJAX service also has one, with
`format: drupal_ajax`.

I'm getting really, really advanced on you guys, but this is the power of the new
way things are done in Drupal. If you wanted to have your own "main_content_renderer"
for some other format, like JSON, all you need to do is create a service, and give
it this tag with the new format. You may never need to do this, but as you dig, Drupal's
layers start to open up.

That's if for now.  If there's something that's confusing you or mysterious in D8,
let me know and we'll dive in together. Ok, see ya guys next time!
