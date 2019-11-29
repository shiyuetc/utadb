<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="Utadb は自分の持ち歌（歌える曲）や気になった曲を記録して管理したりユーザー同士で共有ができるWebサービスです。カラオケ等へ行くとき用にメモ感覚で簡単に使えます。">
<meta name="keywords" content="utadb, karaoke, music, memo, review">
<meta name="author" content="shiyu">
<meta property="og:title" content="Utadb">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ config('app.url') }}">
<meta property="og:description" content="Utadb は自分の持ち歌（歌える曲）や気になった曲を記録して管理したりユーザー同士で共有ができるWebサービスです。カラオケ等へ行くとき用にメモ感覚で簡単に使えます。">
<meta property="og:site_name" content="Utadb">
<meta property="og:image" content="{{ asset('images/icons/flag.png') }}"/>
<meta property="og:locale" content="ja_JP">
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@sakuflip">
<meta name="twitter:title" content="Utadb">
<meta name="twitter:description" content="Utadb は自分の持ち歌（歌える曲）や気になった曲を記録して管理したりユーザー同士で共有ができるWebサービスです。カラオケ等へ行くとき用にメモ感覚で簡単に使えます。">
<meta name="twitter:image" content="{{ asset('images/icons/flag.png') }}">
<title>@if(View::hasSection('title'))@yield('title') - @endif{{ config('app.name', 'Utadb') }}</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/template.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/progres-bar.css') }}">
<link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">