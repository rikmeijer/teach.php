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
        @if (count($contactmomenten) === 0)
            <tr>
                <td colspan="4">{{$slot}}</td>
                <td colspan="3"></td>
            </tr>
        @else
            <?php foreach ($contactmomenten as $contactmoment) : ?>
            <?php if ($contactmoment->isActive()) : ?>
            <tr class="active">
            <?php elseif ($contactmoment->hasPast()) : ?>
            <tr class="past">
            <?php else : ?>
            <tr>
                <?php endif; ?>
                <td><?= $this->escape($contactmoment->getLes()->getModuleNaam()->getNaam()); ?></td>
                <td><?= $this->escape($contactmoment->getKalenderweek()); ?></td>
                <td><?= $this->escape($contactmoment->getBlokweek()); ?></td>
                <td><?= $this->escape($contactmoment->getStarttijd()->format('l')); ?></td>
                <td><?= $this->escape($contactmoment->getStarttijd()->format('H:i')); ?></td>
                <td><?= $this->escape($contactmoment->getEindtijd()->format('H:i')); ?></td>
                <td><a href="<?= $this->url('/feedback/%s', $contactmoment->getId()); ?>" target="_blank">Feedback</a>
                </td>
            </tr>
            <?php endforeach; ?>
        @endif
    @endguest
    </tbody>
</table>
