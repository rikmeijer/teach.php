<table class="multicol">
	<caption>{{ $title }}</caption>
	@if ($activiteit === null)
    	<tr>
    		<th>werkvorm</th>
    		<td id="werkvorm">geen</td>
    		<th>organisatievorm</th>
    		<td id="organisatievorm">geen</td>
    	</tr>
    	<tr>
    		<th>tijd</th>
    		<td id="tijd">0 minuten</td>
    		<th>soort werkvorm</th>
    		<td id="soort werkvorm">geen</td>
    	</tr>
    	<tr>
    		<th>intelligenties</th>
    		<td id="intelligenties" colspan="3">geen</td>
    	</tr>
    	<tr>
    		<th>inhoud</th>
    		<td id="inhoud" colspan="3">geen</td>
    	</tr>
	@else
    	<tr>
    		<th>werkvorm</th>
    		<td id="werkvorm">{{ $activiteit->werkvorm }}</td>
    		<th>organisatievorm</th>
    		<td id="organisatievorm">{{ $activiteit->organisatievorm }}</td>
    	</tr>
    	<tr>
    		<th>tijd</th>
    		<td id="tijd">{{ $activiteit->tijd }} minuten</td>
    		<th>soort werkvorm</th>
    		<td id="soort werkvorm">{{ $activiteit->werkvormsoort }}</td>
    	</tr>
    	<tr>
    		<th>intelligenties</th>
    		<td id="intelligenties" colspan="3"><ul>
    			@foreach (explode(',', $activiteit->intelligenties) as $intelligentie)
    				<li>{{ $intelligentie }}</li>
    			@endforeach
    			</ul></td>
    	</tr>
    	<tr>
    		<th>inhoud</th>
    		<td id="inhoud" colspan="3">{{{ $activiteit->inhoud }}}</td>
    	</tr>
	@endif
</table>