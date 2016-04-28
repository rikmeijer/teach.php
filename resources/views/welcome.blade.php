
@extends('layouts.master')

@section('title', 'Welcome')

@section('content')
	<header>
		<h1>Overzicht contactmomenten</h1>
	</header>
    @foreach ($modules as $module)
    	<section>
    	<h2>{{ $module->naam }}</h2>
    	
    	<ul class="horizontal-menu">
    		<li><a href="/les/add" target="_blank">Les toevoegen</a></li>
    		<li><a href="/contactmomenten/create" target="_blank">Contactmoment toevoegen</a></li>    		
    	</ul>
    	@if (count($module->contactmomenten) === 0)
       		<p>Geen contactmomenten</p>
        @else
    		<table>
    		<caption>Contactmomenten</caption>
    		<thead>
    			<tr>
    				<th width="30">KW</th>
    				<th width="30">BW</th>
    				<th width="80">Dag</th>
    				<th width="80">Starttijd</th>
    				<th width="80">Eindtijd</th>
    				<th width="80">&nbsp;</th>
    				<th>&nbsp;</th>
    			</tr>
    		</thead>
    		<tbody>
    	@foreach ($module->contactmomenten as $contactmoment)
			<tr>
				<td>{{ $contactmoment->les->lesweek->kalenderweek }}</td>
				<td>{{ $contactmoment->les->lesweek->blokweek }}</td>
				<td>{{ $contactmoment->starttijd->format('l') }}</td>
				<td>{{ $contactmoment->starttijd->format('H:i') }}</td>
				<td>{{ $contactmoment->eindtijd->format('H:i') }}</td>
				<td><a href="/contactmoment/{{ $contactmoment->id }}" target="_blank">Lesplan</a></td>
				<td>
				@foreach ($ipv4Adresses as $ipv4Adress)
					<a href="http://{{ $ipv4Adress }}/feedback/{{ $contactmoment->id }}" target="_blank">Feedback ({{ $ipv4Adress }})</a>
				@endforeach
				</td>
			</tr>
			@endforeach
        </tbody>
    		</table>
        @endif
        
        </section>
    @endforeach
@endsection