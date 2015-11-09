- download
- install
- move example.gitignore to .gitignore
- ignore and core/
- commit to git

QUESTIONS:
- role of example.sites.php, example.settings.local.php
- default.services.yml
- you can copy default.services.yml to services.yml and it'll be loaded
- then you copy example.settings.local.php into settings.local.php
    in your sites/default directory and update settings.php to import this.
- are all the keys in dino_roar.info.yml necessary?

PLAN
- 3 steps to a page: module, route, controller
    - https://speakerdeck.com/weaverryan/drupalcon-2015-routes-controllers-and-responses-the-basic-lifecycle-of-a-d8-request
- create a module (dino_roar?)
    - package: Sample is just the category visually it goes into
- enable it in the admin
- create routing file
    - hook_menu?
- create controller, return a Response
- pass a wildcard in the route
- get drupal console
    - router:debug
- web profiler???
- introduce services
- show list of core services in profiler
    - show core.services.yml
- introduce a new service and use it
- show all the core events
- add a listener the them
- render array - it should not work - who creates the response?
- "content rendereres"
- param converters?
- how _form works: listener that sets _controller
- showing more from dupalconsole?

- container
- events
- reverse-engineering core pages
+ webprofiler?
+ console for debugging