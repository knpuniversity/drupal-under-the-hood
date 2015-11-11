# Service Arguments

We extended `ControllerBase` which gave us access to this create function workflow where
we can pass services to our own controller and then use them. So cool!

But, we also have access to a bunch of helper functions. For example, the `$keyvaluestore`.
In Drupal 8 there is a way that you can just have a key value store and you can back that with
a database or with redis, it allows you to put things somewhere and fetch them out. As soon as
you extend `ControllerBase` you can get a `$keyvaluestore` by typing `$this->keyValue()` and
that is a built in function on `ControllerBase` and you can pass it some collection string that
you want to search for. Let's try this out. `$keyValueStore->set('roar_string', $roar);`
