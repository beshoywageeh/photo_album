<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('layout.css')
    <title>Album</title>
  </head>
  <body>
    @include('layout.nav')

    <div class="container">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
        @endif
        @yield('content')</div>
    @include('layout.js')
  </body>
</html>
