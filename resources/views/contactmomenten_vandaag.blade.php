<table id="contactmomenten-vandaag">
    <caption>{{$caption}}</caption>
    <thead>
    <tr>
        <th class="medium">Module</th>
        <th class="small">KW</th>
        <th class="small">BW</th>
        <th class="medium">Dag</th>
        <th class="medium">Starttijd</th>
        <th class="medium">Eindtijd</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @guest
        <tr>
            <td colspan="4">{{$slot}}</td>
            <td colspan="3"></td>
        </tr>
    @else
        @if (count($contactmomenten) === 0)
            <tr>
                <td colspan="4">{{$slot}}</td>
                <td colspan="3"></td>
            </tr>
        @else
            @foreach($contactmomenten as $contactmoment)
                @if($contactmoment->active)
                    <tr class="active">
                @elseif($contactmoment->past)
                    <tr class="past">
                @else
                    <tr>
                        @endif

                        <td>{{$contactmoment->les->module->naam}}</td>
                        <td>{{$contactmoment->les->lesweek->kalenderweek}}</td>
                        <td>{{$contactmoment->les->lesweek->blokweek}}</td>
                        <td>{{$contactmoment->starttijd->format('l')}}</td>
                        <td>{{$contactmoment->starttijd->format('H:i')}}</td>
                        <td>{{$contactmoment->eindtijd->format('H:i')}}</td>
                        <td><a href="{{ url('/feedback/%s', $contactmoment->id) }}" target="_blank">Feedback</a>
                        </td>
                    </tr>
                    @endforeach
                @endif
                @endguest
    </tbody>
</table>
