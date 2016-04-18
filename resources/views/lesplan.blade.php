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
    			@foreach ($contactmoment->les->media as $mediaTitle)
    				<li>{{ $mediaTitle }}</li>
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
		<table>
			<caption>Huiswerk</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">presentatie</td>
				<th>organisatievorm</th>
				<td id="organisatievorm">plenair</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd">2 minuten</td>
				<th>soort werkvorm</th>
				<td id="soort werkvorm">docent gecentreerd</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td id="intelligenties" colspan="3"><ul>
						<li>VL</li>
						<li>IR</li>
					</ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"><ul>
						<li>Challenge voor eerstvolgende les maken</li>
						<li>Practicum opdrachten thuis afronden</li>
						<li>Huiswerk maken als extra oefening</li>
					</ul></td>
			</tr>
		</table>
		<table>
			<caption>Evaluatie</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">nabespreking</td>
				<th>organisatievorm</th>
				<td id="organisatievorm">plenair</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd">3 minuten</td>
				<th>soort werkvorm</th>
				<td id="soort werkvorm">docent gecentreerd</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td id="intelligenties" colspan="3"><ul>
						<li>VL</li>
						<li>IR</li>
					</ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"><ul>
						<li>Verzamelen feedback papiertjes</li>
					</ul></td>
			</tr>
		</table>
		<table>
			<caption>Pakkend slot</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">presentatie</td>
				<th>organisatievorm</th>
				<td id="organisatievorm">plenair</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd">1 minuten</td>
				<th>soort werkvorm</th>
				<td id="soort werkvorm">docent gecentreerd</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td id="intelligenties" colspan="3"><ul>
						<li>VL</li>
						<li>VR</li>
						<li>IR</li>
					</ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"><ul>
						<li>Foto; gerelateerd aan keuzes/condities. Misschien foto van</li>
						<li>blauwe/rode pil Matrix.</li>
					</ul></td>
			</tr>
		</table>
	</section>
</body>
</html>