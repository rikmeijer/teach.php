<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Lesplan PROG1</title>
<link rel="stylesheet" type="text/css" href="/css/lesplan.css">
</head>
<body>
	<header>
		<h1>Lesplan {{ $les->module->naam }}</h1>
		<h2>HBO-informatica (voltijd)</h2>
	</header>
	<section>
		<h2>{{ $les->naam }}</h2>
		<h3>Beginsituatie</h3>
		<table>
			<tr>
				<th>doelgroep</th>
				<td id="doelgroep">eerstejaars HBO-studenten</td>
				<th>ervaring</th>
				<td id="ervaring">geen</td>
			</tr>
			<tr>
				<th>groepsgrootte</th>
				<td id="groepsgrootte" colspan="3">16 personen</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd" colspan="3">van 08:45 tot 10:20 (95 minuten)</td>
			</tr>
			<tr>
				<th>ruimte</th>
				<td id="ruimte" colspan="3">beschikking over vaste computers</td>
			</tr>
			<tr>
				<th>overige</th>
				<td id="overige" colspan="3">nvt</td>
			</tr>
		</table>
		<h3>Media</h3>
		<ul>
			<li>filmfragment matrix</li>
			<li>countdown timer voor toepassingsfases (optioneel)</li>
			<li>voorbeeld IKEA-handleiding + uitgewerkte pseudo-code</li>
			<li>rode en groene briefjes/post-its voor feedback</li>
			<li>voorbeeldproject voor aanvullende feedback</li>
		</ul>
		<h3>Leerdoelen</h3>
		<p>Na afloop van de les kan de student:</p>
		<ul>
			<li>Zelfstandig eclipse installeren</li>
			<li>Java-code lezen en uitleggen wat er gebeurt</li>
		</ul>
	</section>
	<section>
		<h2>Introductie</h2>
		<table>
			<caption>Activerende opening</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">film</td>
				<th>organisatievorm</th>
				<td id="organisatievorm">plenair</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd">5 minuten</td>
				<th>soort werkvorm</th>
				<td id="soort werkvorm">ijsbreker</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td id="intelligenties" colspan="3"><ul>
						<li>VL</li>
						<li>VR</li>
						<li>IR</li>
						<li>IA</li>
					</ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"><ul>
						<li>Scen&eacute; uit de matrix tonen waarop wordt gezegd: &quot;I
							don't</li>
						<li>even see the code&quot;. Wie kent deze film? Een ervaren
							programmeur</li>
						<li>zal een vergelijkbaar gevoel hebben bij code: programmeren is
							een</li>
						<li>visualisatie kunnen uitdrukken in code en vice versa.</li>
					</ul></td>
			</tr>
		</table>
		<table>
			<caption>Focus</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">presentatie</td>
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
						<li>LM</li>
						<li>IR</li>
					</ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"><ul>
						<li>Visie, Leerdoelen, Programma, Afspraken</li>
					</ul></td>
			</tr>
		</table>
		<table>
			<caption>Voorstellen</caption>
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
						<li>LM</li>
						<li>IR</li>
					</ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"><ul>
						<li>Voorstellen Docent</li>
					</ul></td>
			</tr>
		</table>
		<table>
			<caption>Kennismaken</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">onbekend</td>
				<th>organisatievorm</th>
				<td id="organisatievorm">nvt</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd">0 minuten</td>
				<th>soort werkvorm</th>
				<td id="soort werkvorm">onbekend</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td id="intelligenties" colspan="3"><ul></ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"></td>
			</tr>
		</table>
		<table>
			<caption>Terugblik</caption>
			<tr>
				<th>werkvorm</th>
				<td id="werkvorm">onbekend</td>
				<th>organisatievorm</th>
				<td id="organisatievorm">nvt</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td id="tijd">0 minuten</td>
				<th>soort werkvorm</th>
				<td id="soort werkvorm">onbekend</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td id="intelligenties" colspan="3"><ul></ul></td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td id="inhoud" colspan="3"></td>
			</tr>
		</table>
	</section>
	<section>
		<h2>Kern</h2>
		<section>
			<h3>Thema 1: Zelfstandig eclipse installeren</h3>
			<table>
				<caption>Ervaren</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">verhalen vertellen bij foto's</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">5 minuten</td>
					<th>soort werkvorm</th>
					<td id="soort werkvorm">ijsbreker</td>
				</tr>
				<tr>
					<th>intelligenties</th>
					<td id="intelligenties" colspan="3"><ul>
							<li>VL</li>
							<li>VR</li>
							<li>N</li>
							<li>IR</li>
						</ul></td>
				</tr>
				<tr>
					<th>inhoud</th>
					<td id="inhoud" colspan="3"><ul>
							<li>Tonen afbeeldingen van werkomgevingen: wie herkent de</li>
							<li>werkomgeving?</li>
						</ul></td>
				</tr>
			</table>
			<table>
				<caption>Reflecteren</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">brainstormen</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">5 minuten</td>
					<th>soort werkvorm</th>
					<td id="soort werkvorm">discussie</td>
				</tr>
				<tr>
					<th>intelligenties</th>
					<td id="intelligenties" colspan="3"><ul>
							<li>VL</li>
							<li>IR</li>
							<li>IA</li>
						</ul></td>
				</tr>
				<tr>
					<th>inhoud</th>
					<td id="inhoud" colspan="3"><ul>
							<li>5 minuten brainstormen om te reflecteren op de voorgaande</li>
							<li>afbeeldingen.</li>
							<li>De uiteindelijke vraag om te beantwoorden: 'Hoe zou een
								werkplaats</li>
							<li>voor een programmeur eruit zien?'</li>
							<li>Wat valt er op aan deze werkplaatsen?</li>
							<li>Link leggen naar een programmeeromgeving: niet fysiek, maar
								virtueel.</li>
							<li>Wie kan bedenken wat voor gereedschap erbij programmeren komt</li>
							<li>kijken?</li>
						</ul></td>
				</tr>
			</table>
			<table>
				<caption>Conceptualiseren</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">presentatie</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">5 minuten</td>
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
							<li>Kort uitleggen wat IDE/eclipse is</li>
							<li>(programmeeromgeving)/waarvoor het wordt gebruikt.</li>
							<li>Korte demo ter kennismaking</li>
							<li>Wat zijn de randvoorwaarden van de installatie?</li>
							<li>!! Laatste sheet met randvoorwaarden open laten</li>
						</ul></td>
				</tr>
			</table>
			<table>
				<caption>Toepassen</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">verwerkingsopdracht</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">15 minuten</td>
					<th>soort werkvorm</th>
					<td id="soort werkvorm">individuele werkopdracht</td>
				</tr>
				<tr>
					<th>intelligenties</th>
					<td id="intelligenties" colspan="3"><ul>
							<li>VL</li>
							<li>IA</li>
						</ul></td>
				</tr>
				<tr>
					<th>inhoud</th>
					<td id="inhoud" colspan="3"><ul>
							<li>Student installeert zelf eclipse</li>
							<li>Aanvullende opdracht (capaciteit): importeren
								voorbeeldproject van blackboard</li>
							<li>of een nieuw project aanmaken</li>
							<li>Na 10min controleren of dit bij iedereen is gelukt</li>
						</ul></td>
				</tr>
			</table>
		</section>
		<section>
			<h3>Thema 2: Java-code lezen en uitleggen wat er gebeurt</h3>
			<table>
				<caption>Ervaren</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">metafoor</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">5 minuten</td>
					<th>soort werkvorm</th>
					<td id="soort werkvorm">ijsbreker</td>
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
							<li>Achterhalen wie wel eens adhv van een recept/handleiding
								heeft</li>
							<li>gewerkt.</li>
						</ul></td>
				</tr>
			</table>
			<table>
				<caption>Reflecteren</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">brainstormen</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">groepswerk</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">5 minuten</td>
					<th>soort werkvorm</th>
					<td id="soort werkvorm">discussie</td>
				</tr>
				<tr>
					<th>intelligenties</th>
					<td id="intelligenties" colspan="3"><ul>
							<li>VL</li>
							<li>LM</li>
							<li>IR</li>
							<li>IA</li>
						</ul></td>
				</tr>
				<tr>
					<th>inhoud</th>
					<td id="inhoud" colspan="3"><ul>
							<li>Studenten met buurman/vrouw overleggen hoeveel verschillende</li>
							<li>stappen er zijn bij het uitvoeren van een handleiding.
								Tijdens het</li>
							<li>uitvoeren van taken voeren wij onbewust veel contextgevoelige
								taken</li>
							<li>uit een computer kent dit niet.</li>
						</ul></td>
				</tr>
			</table>
			<table>
				<caption>Conceptualiseren</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">demonstratie</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">10 minuten</td>
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
							<li>Tonen pseudo-code bij vorig recept of handleiding (bijv. IKEA</li>
							<li>handleiding)</li>
						</ul></td>
				</tr>
			</table>
			<table>
				<caption>Toepassen</caption>
				<tr>
					<th>werkvorm</th>
					<td id="werkvorm">verwerkingsopdracht</td>
					<th>organisatievorm</th>
					<td id="organisatievorm">plenair</td>
				</tr>
				<tr>
					<th>tijd</th>
					<td id="tijd">30 minuten</td>
					<th>soort werkvorm</th>
					<td id="soort werkvorm">individuele werkopdracht</td>
				</tr>
				<tr>
					<th>intelligenties</th>
					<td id="intelligenties" colspan="3"><ul>
							<li>VL</li>
							<li>IA</li>
						</ul></td>
				</tr>
				<tr>
					<th>inhoud</th>
					<td id="inhoud" colspan="3"><ul>
							<li>SIMPEL: uitleggen wat de code doet</li>
							<li>BASIS: schrijven pseudo-code</li>
							<li>COMPLEX: zelf code schrijven, als voorschot op volgende week
								(extra</li>
							<li>uitdaging).</li>
						</ul></td>
				</tr>
			</table>
		</section>
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