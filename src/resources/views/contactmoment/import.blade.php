
@extends('layouts.master')

@section('title', 'Importeer contactmomenten')

@section('content')
	<header>
		<h1>Importeer contactmomenten</h1>
	</header>
    <section>
    	<form method="post">
			<input type="hidden" name="__csrf_value" value="<?= htmlspecialchars($csrf_value, ENT_QUOTES, 'UTF-8'); ?>">
    		Type: <ul>
    		<li>
    			<input type="radio" name="type" value="ics" selected />ICS<br/>
    			URL: <input type="text" name="url" />
    		</li>
    		<li>
    			<input type="radio" name="type" value="avansroosterjson" />Avans Rooster JSON<br/ >
    			JSON: <textarea type="text" name="json" rows="10" cols="50"></textarea>
    		</li>
    		</ul> 
    		<input type="submit" value="Importeren" />
    	</form>
    </section>
@endsection