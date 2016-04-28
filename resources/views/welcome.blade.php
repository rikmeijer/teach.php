
@extends('layouts.master')

@section('title', 'Welcome')

@section('content')
    @foreach ($contactmomenten as $contactmoment)
    	<section>
    	<h2>{{ $contactmoment->les->module->naam }} {{ $contactmoment->les->naam }} {{ date('H:i', strtotime($contactmoment->starttijd)) }}</h2>
    	<ul>
    		<li><a href="/contactmomenten/{{ $contactmoment->id }}" target="_blank">Lesplan</a></li>
    		@foreach ($ipv4Adresses as $ipv4Adress)
    			<li><a href="http://{{ $ipv4Adress }}/feedback/{{ $contactmoment->id }}" target="_blank">Feedback ({{ $ipv4Adress }})</a></li> 
    		@endforeach    		
    	</ul>
    	</section>
    @endforeach
    
	<section>
	<ul>
		<li><a href="/les/add" target="_blank">Les toevoegen</a></li>
		<li><a href="/contactmomenten/create" target="_blank">Contactmoment toevoegen</a></li>    		
	</ul>
	</section>
@endsection