<!DOCTYPE html>
<html class="h-full">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @vite('resources/js/app.js')
    @inertiaHead
    @routes
  </head>
  <body class="h-full">
    @inertia
  </body>
</html>