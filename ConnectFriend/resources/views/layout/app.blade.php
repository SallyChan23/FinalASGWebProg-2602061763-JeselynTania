<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Friend</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+AU+SA:wght@100..400&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        @include('component.navbar')
    </header>

    <main>
        @yield('content')
    </main>
    
</body>

<style>
    h1, .navbar-brand {
        font-family: "Playwrite AU SA", serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
    }

    body {
        font-family: "Merriweather", serif;
        font-weight: 400;
        font-style: normal;
        background-color: #FFFDF0 ;
    }

    li {
        color: #000;
        font-size: large;
    }
</style>
</html>