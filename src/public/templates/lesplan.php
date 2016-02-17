<?php
return function(\Teach\Adapters\HTML\Factory $factory, \Teach\Interactors\Web\Lesplan $lesplan) {
    return <<<"EOF"
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>Lesplan</title>
    <link rel="stylesheet" type="text/css" href="lesplan.css">
    </head>
    <body>
    {$factory->makeHTMLFrom($lesplan)}
    </body>
    </html>
EOF;
};