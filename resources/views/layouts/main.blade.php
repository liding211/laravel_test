<html>
    <head>
        <title>Desk - @yield('title')</title>
        @section('style')
            <style type="text/css"></style>
        @show
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    </head>
    <body>
        <header>
            <a href="<?= url("/"); ?>">Go to main</a>
            @section('add_button')
                | <a href="<?= url("new_ad"); ?>">Add your ad!</a>
            @show
        </header>

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>