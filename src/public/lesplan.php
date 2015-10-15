<?php
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';
$applicationBootstrap();

?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Lesplan</title>
<style>
body {
	font-family: sans-serif;
	line-height: 1.5em;
}

body header {
	text-align: center;
}

body table {
	width: 210mm;
	border-spacing: 0;
}

body section h3 {
	color: #ff6600;
}

table caption {
	color: #aa6600;
}

table td, table th {
	padding: 5px;
}

table th {
	text-align: right;
	background-color: #f6f6f6;
	vertical-align: top;
	width: 20%;
}

table.two-columns th {
	width: 10%;
}

ul.meervoudige-intelligenties {
	list-style: none;
	margin: 0;
	padding:0;
}
ul.meervoudige-intelligenties li {
	float:left;
	padding: 0 5px;
	color: #d0d0d0;
}
ul.meervoudige-intelligenties li.selected {
	color: #000000;
}


hr {
	border: 0;
	height: 1px;
	background: #333;
}

@media print {
	body header, section {
		page-break-after: always;
	}
}
</style>
</head>
<body>
	<header>
		<h1>Lesplan programmeren</h1>
		<h2>Blok 1 / Week 1 / Les 1</h2>
	</header>
	<section>
		<h3>Beginsituatie</h3>
		<table>
			<tr>
				<th>doelgroep</th>
				<td>eerstejaars HBO-studenten</td>
				<th>opleiding</th>
				<td>HBO-informatica (<del>deeltijd</del>/voltijd)
				</td>
			</tr>
			<tr>
				<th>ervaring</th>
				<td><del>veel</del>, <del>redelijk veel</del>, <del>weinig</del>,
					geen</td>
				<th>groepsgrootte</th>
				<td>ca. 16 personen</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td>van <strong>8:45</strong> tot <strong>10:20</strong> (45
					minuten)
				</td>
				<th>ruimte</th>
				<td>beschikking over vaste computers</td>
			</tr>
			<tr>
				<th>overige</th>
				<td colspan="3">nvt</td>
			</tr>
		</table>
		<h3>Benodigde media</h3>
		<ul>
			<li>filmfragment matrix</li>
			<li>rode en groene briefjes/post-its voor feedback</li>
			<li>presentatie</li>
			<li>voorbeeldproject voor aanvullende feedback</li>
		</ul>
		<h3>Leerdoelen</h3>
		<p>Na afloop van de les kan de student:</p>
		<ol>
			<li>Zelfstandig eclipse installeren</li>
			<li>Java-code lezen en uitleggen wat er gebeurt</li>
		</ol>
	</section>
	<hr />
	<section>
		<h3>Introductie</h3>
		<table>
			<caption>Activerende opening</caption>
			<tr>
				<th>werkvorm</th>
				<td>film</td>
			</tr>
			<tr>
				<th>tijd</th>
				<td>5 minuten</td>
			</tr>
			<tr>
				<th>organisatievorm</th>
				<td>plenair</td>
			</tr>
			<tr>
				<th>soort werkvorm</th>
				<td>ijsbreker</td>
			</tr>
			<tr>
				<th>intelligenties</th>
				<td>
					<ul class="meervoudige-intelligenties">
						<li id="verbaal-linguistisch" class="selected">VL</li>
						<li id="logisch-mathematisch">LM</li>
						<li id="visueel-ruimtelijk" class="selected">VR</li>
						<li id="muzikaal-ritmisch">MR</li>
						<li id="lichamelijk-kinesthetisch">LK</li>
						<li id="naturalistisch">N</li>
						<li id="interpersoonlijk" class="selected">IR</li>
						<li id="intrapersoonlijk" class="selected">IA</li>
					</ul>
				</td>
			</tr>
			<tr>
				<th>inhoud</th>
				<td>Scen&eacute; uit de matrix tonen waarop wordt gezegd:
					&quot;I don&rsquo;t even see the code&quot;. Wie kent deze film?
					Een ervaren programmeur zal een vergelijkbaar gevoel hebben bij
					code: programmeren is een visualisatie kunnen uitdrukken in code en
					vice versa.</td>
			</tr>
		</table>
	</section>
</body>
</html>