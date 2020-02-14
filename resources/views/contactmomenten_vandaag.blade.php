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
    @elseguest
    @endauth
    </tbody>
</table>
