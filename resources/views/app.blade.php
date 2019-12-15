<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Utadb') }}</title>
  <link rel="stylesheet" href="/css/app.css">
  <link rel="stylesheet" href="/css/template.css">
  <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script>
    window.Laravel = {};
    window.Laravel.csrfToken = "{{ csrf_token() }}";
  </script>
</head>
<body>
  <div id="app"></div>
</body>
<script type="text/javascript" src="/js/app.js"></script>
</html>