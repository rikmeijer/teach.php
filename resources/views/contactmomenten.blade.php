<table>
	<caption>{{ $caption }}</caption>
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
		@foreach ($contactmomenten as $contactmoment)
		@if ($contactmoment->active) 
			<tr class="active">
		@else
			<tr>
		@endif
			<td>{{ $contactmoment->les->lesweek->kalenderweek }}</td>
			<td>{{ $contactmoment->les->lesweek->blokweek }}</td>
			<td>{{ $contactmoment->starttijd->formatLocalized('%A') }}</td>
			<td>{{ $contactmoment->starttijd->format('H:i') }}</td>
			<td>{{ $contactmoment->eindtijd->format('H:i') }}</td>
			<td><a href="/contactmoment/{{ $contactmoment->id }}" target="_blank">Lesplan</a></td>
			<td>@foreach ($ipv4Adresses as $ipv4Adress) <a
				href="http://{{ $ipv4Adress }}/feedback/{{ $contactmoment->id }}"
				target="_blank">Feedback ({{ $ipv4Adress }})</a> @endforeach
			</td>
		</tr>
		@endforeach
	</tbody>
</table>