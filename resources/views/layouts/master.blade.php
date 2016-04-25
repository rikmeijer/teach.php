
<!DOCTYPE html>
<html>
    <head>
        <title>Teach - @yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-family: Verdana, sans-serif;
            }
            
            h1 {
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>