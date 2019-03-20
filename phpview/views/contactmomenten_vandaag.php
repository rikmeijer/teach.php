<?php if (count($contactmomenten) === 0) : ?>
    <p>Geen <?= $this->escape(strtolower($caption)); ?></p>
<?php else : ?>
    <table>
        <caption><?= $this->escape($caption); ?></caption>
        <thead>
        <tr>
            <th width="80">Module</th>
            <th width="30">KW</th>
            <th width="30">BW</th>
            <th width="80">Dag</th>
            <th width="80">Starttijd</th>
            <th width="80">Eindtijd</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($contactmomenten as $contactmoment) : ?>
            <?php if ($contactmoment->active) : ?>
                <tr class="active">
            <?php elseif ($contactmoment->past) : ?>
                <tr class="past">
            <?php else : ?>
                <tr>
            <?php endif; ?>
            <td><?= $this->escape($contactmoment->modulenaam); ?></td>
            <td><?= $this->escape($contactmoment->kalenderweek); ?></td>
            <td><?= $this->escape($contactmoment->blokweek); ?></td>
            <td><?= $this->escape($contactmoment->starttijd->format('l')); ?></td>
            <td><?= $this->escape($contactmoment->starttijd->format('H:i')); ?></td>
            <td><?= $this->escape($contactmoment->eindtijd->format('H:i')); ?></td>
            <td><a href="<?= $this->url('/feedback/%s', $contactmoment->id); ?>" target="_blank">Feedback</a>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
