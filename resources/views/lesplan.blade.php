<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Lesplan PROG1</title>
<link rel="stylesheet" type="text/css" href="/css/lesplan.css">
</head>
<body>
	<header>
		<h1>Lesplan {{ $contactmoment->les->module->naam }}</h1>
		<h2>HBO-informatica (voltijd)</h2>
	</header>
	<section>
		<h2>{{ $contactmoment->les->naam }}</h2>
		<h3>Beginsituatie</h3>
		<table>
			<tr>
				<th>doelgroep</th>
				<td id="doelgroep">{{ $contactmoment->les->doelgroep->beschrijving }}</td>
				<th>ervaring</th>
				<td id="ervaring">{{ $contactmoment->les->doelgroep->ervaring }}</td>
			</tr>
			<tr>
				<th>groepsgrootte</th>
				<td id="groepsgrootte" colspan="3">{{ $contactmoment->les->doelgroep->grootte }} personen</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd" colspan="3">van {{ date('H:i', strtotime($contactmoment->starttijd)) }} tot {{ date('H:i', strtotime($contactmoment->eindtijd)) }} ({{ $contactmoment->duur }} minuten)</td>
			</tr>
			<tr>
				<th>ruimte</th>
				<td id="ruimte" colspan="3">{{ $contactmoment->ruimte }}</td>
			</tr>
			<tr>
				<th>overige</th>
				<td id="overige" colspan="3">{{ $contactmoment->les->opmerkingen }}</td>
			</tr>
		</table>
		@if (count($contactmoment->les->media) > 0)
    		<h3>Media</h3>
    		<ul>
    			@foreach ($contactmoment->les->media as $medium)
    				<li>{{ $medium->omschrijving }}</li>
    			@endforeach
    		</ul>
        @endif
		<h3>Leerdoelen</h3>
		<p>Na afloop van de les kan de student:</p>
		<ul>
			<li>Zelfstandig eclipse installeren</li>
			<li>Java-code lezen en uitleggen wat er gebeurt</li>
		</ul>
	</section>
	<section>
		<h2>Introductie</h2>
		@include('activiteit', [
			'title'=> 'Activerende opening',
			'activiteit' => $contactmoment->les->activerendeOpening
		])
		@include('activiteit', [
			'title'=> 'Focus',
			'activiteit' => $contactmoment->les->focus
		])
		@include('activiteit', [
			'title'=> 'Voorstellen',
			'activiteit' => $contactmoment->les->voorstellen
		])
		@include('activiteit', [
			'title'=> 'Kennismaken',
			'activiteit' => $contactmoment->les->kennismaken
		])
	</section>
	<section>
		<h2>Kern</h2>
		@foreach ($contactmoment->les->themas as $index => $thema)
		<section>
			<h3>Thema {{ $index+1 }}: {{ $thema->leerdoel }}</h3>
        		@include('activiteit', [
        			'title'=> 'Ervaren',
        			'activiteit' => $thema->ervaren
        		])
        		@include('activiteit', [
        			'title'=> 'Reflecteren',
        			'activiteit' => $thema->reflecteren
        		])
        		@include('activiteit', [
        			'title'=> 'Conceptualiseren',
        			'activiteit' => $thema->conceptualiseren
        		])
        		@include('activiteit', [
        			'title'=> 'Toepassen',
        			'activiteit' => $thema->toepassen
        		])
		</section>
		@endforeach
	</section>
	<section>
		<h2>Afsluiting</h2>
		@include('activiteit', [
			'title'=> 'Huiswerk',
			'activiteit' => $contactmoment->les->huiswerk
		])
		@include('activiteit', [
			'title'=> 'Evaluatie',
			'activiteit' => $contactmoment->les->evaluatie
		])
		@include('activiteit', [
			'title'=> 'Pakkend slot',
			'activiteit' => $contactmoment->les->pakkendSlot
		])
	</section>
</body>
</html>