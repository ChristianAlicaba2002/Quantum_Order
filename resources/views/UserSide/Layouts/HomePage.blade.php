<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/logo.jpg" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{Auth::user()->firstName}}</title>
</head>
<style>
    body{
        width: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<body>
    @extends('UserSide.Pages.HeaderPage')
</body>
</html>