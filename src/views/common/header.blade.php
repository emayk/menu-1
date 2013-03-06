<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="{{ URL::asset('/packages/wingsline/menu/css/main.css') }}">
<title>Wingsline/Menu</title>
</head>
<body>
<h1>Wingsline/Menu</h1>
<p class="warnings">The <a href="{{ URL::route('admin.index')}}">menu editor</a> is not intended for use in production environments!</p>
@include ('menu::common.testlist')
