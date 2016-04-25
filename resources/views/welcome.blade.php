<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

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
            <div class="content">
                
                @foreach ($contactmomenten as $contactmoment)
                	<section>
                	<h1>{{ $contactmoment->les->module->naam }} {{ $contactmoment->les->naam }}</h1>
                	<ul>
                		<li><a href="/contactmoment/{{ $contactmoment->id }}" target="_blank">Lesplan</a></li>
                		@foreach ($ipv4Adresses as $ipv4Adress)
                			<li><a href="http://{{ $ipv4Adress }}/feedback/{{ $contactmoment->id }}" target="_blank">Feedback ({{ $ipv4Adress }})</a></li> 
                		@endforeach    		
                	</ul>
                	</section>
                @endforeach
                
            	<section>
            	<ul>
            		<li><a href="/lesplan/add" target="_blank">Lesplan toevoegen</a></li>
            		<li><a href="/contactmoment/add" target="_blank">Contactmoment toevoegen</a></li>    		
            	</ul>
            	</section>
            </div>
        </div>
    </body>
</html>
