@extends('layouts.master')

@section('title', 'Welcome')

@section('content')
<header>
	<h1>Overzicht contactmomenten</h1>
</header>

<nav>
	<ul class="horizontal-menu">
		@foreach ($modules as $module)
		<li><a href="#{{ $module->naam }}">{{ $module->naam }}</a></li>
		@endforeach
	</ul>
</nav>
<section>
	@include('contactmomenten', [
		'caption'=> 'Contactmomenten vandaag',
		'contactmomenten' => $contactmomenten
	])
</section>

@foreach ($modules as $module)
<section>
	<a name="{{ $module->naam }}"></a>
	<h2>{{ $module->naam }}</h2>

	<ul class="horizontal-menu">
		<li><a href="/les/add" target="_blank">Les toevoegen</a></li>
		<li><a href="/contactmomenten/create" target="_blank">Contactmoment
				toevoegen</a></li>
	</ul>
	@include('contactmomenten', [
		'caption'=> 'Contactmomenten',
		'contactmomenten' => $module->contactmomenten
	])

</section>
@endforeach @endsection
