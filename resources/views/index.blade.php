<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MISstats</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uikit.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uikit.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uikit-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/uikit-icons.css') }}">

</head>
<body>
<div id="app">
<router-view></router-view>
<br><br><br><br>    


</div>

<script src="{{ asset('js/store.js') }}"> </script>
<script src="{{ asset('js/uikit-icons.js') }}"></script>
<script src="{{ asset('js/uikit.min.js') }}"></script>
<script src="{{ asset('js/uikit.js') }}"></script>
<script src="{{ asset('js/app.js') }}"> </script>
</body>
</html>