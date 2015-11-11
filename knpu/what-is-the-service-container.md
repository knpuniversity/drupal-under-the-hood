# What is the Service Container?

Ok, the first half of the Symfony stuff was the route, controller, Response
flow. Check that off your list.

The second half is all about these magical, wonderful things called unicorns, ahem
services! Write it down on your buzzword notepad - you will hear this word a lot,
normally by people who are trying to scare you.

## Wtf is a Service???

Here's the truth: a service is.... a useful object. Wooooh, ooo, it's not so scary,
don't believe the hype! A service is a class that you or someone else creates that
does some work for you.

For example, suppose you have a class that logs messages. Hey, that's a service,
because you can call a method on it and that will save a log somewhere. Or say you
have another class - a mailer that sends emails. OMG, it's a service!!!!

Ok, so what's an example of a class that does *not* help you? Multivariable Calculus
-- jk I studied math in college, and Multivariable Calculus helps me every
day to calculate the tip at restaurants. Totally worth it.

But really, a class that is *not* a service might be the `Node` class or some `Product`
class you create that stores data. These classes don't do a lot of work, they mostly
exist to store data.

Enough with your theory! If this doesn't make sense, it's cool guys. The takeaway
is that when I say "Service", you should yell back "An object that does work for me".
Try it: Service! "An object that does work for me". That was actually me.

## Wtf is a Service Container?

The next buzz word is "service container". We also call it a "dependency injection
container": that's our favorite term to use when we *really* want to terrify someone.

Here's the deal: in Drupal - and Symfony - there is a single object called the container.
It's basically an associative array of services. In fact, it holds *every* useful
object in the system and each has a nickname. When you want to get access to a service
so you can use it to do work for you, you just say

> Yo, Mr Container! Can I get the service who's nickname is logger.factory, please?

Saying please boosts performance by 20%, so mind your manners.

Here's the coolest part: *everything* that Drupal does is actually done by one of
the services in the container. The execution of the routing, the handling of the
cache, the reading of configuration: these are all done by different services. And
guess what? You have access to use these at any time. You can even override and replace
*any* core service you want. I'm blowing my own mind.
