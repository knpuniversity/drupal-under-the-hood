# Routing Wildcards

Routing is packed with cool little features, but the most common thing you'll see
is the addition of wildcards. Add a `/{count}` to the end of the route's `path`:

[[[ code('030e4d5d04') ]]]

Because this is surrounded with curly-braces, the route will now match `/the/dino/says/*anything*`,

As soon as you have a routing wildcard called `count`, you can suddenly have a `$count`
argument in your controller function:

[[[ code('7964450c6e') ]]]

The value for for the `{count}` part in the URL is passed to the `$count` argument.
Both the wildcard and the argument must have the same name.

Use `$count` to change our scary greeting: `$roar = 'R'.str_repeat('0', $count).'AR!'`.
Pass this to the `Response`:

[[[ code('f138ac32fa') ]]]

We just changed the route configuration, so we need to rebuild the routing cache:

```bash
drupal router:rebuild
```

Once I do, the `/the/dino/says` page returns a 404! Ah! As soon as you add `/{count}`
to the route path, the route only matches when *something* is passed there. We need
`/the/dino/says/*something*`, anything but blank. There *are* ways to make the wildcard
optional - check out the Symfony routing docs.

Add `10` to the end of the URL:

> http://localhost:8000/the/dino/says/10

Rooooooooooar! Make it 50 and the rooooooooooo....oooooooar gets longer.

Woah! You now know half of the new stuff in Drupal 8. It's this routing/controller
layer. Make a route, then a controller and make that controller return a Response.
Seriously, can we go on vacation now?
