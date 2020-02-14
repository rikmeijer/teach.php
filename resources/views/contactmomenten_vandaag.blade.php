<table>
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

                        <td>{{$contactmoment->getLes()->getModuleNaam()->getNaam()}}</td>
                        <td>{{$contactmoment->getKalenderweek()}}</td>
                        <td>{{$contactmoment->getBlokweek()}}</td>
                        <td>{{$contactmoment->getStarttijd()->format('l')}}</td>
                        <td>{{$contactmoment->getStarttijd()->format('H:i')}}</td>
                        <td>{{$contactmoment->getEindtijd()->format('H:i')}}</td>
                        <td><a href="{{ url('/feedback/%s', $contactmoment->getId()) }}" target="_blank">Feedback</a>
                        </td>
                    </tr>
                    @endforeach
                @endif
                @endguest
    </tbody>
</table>
