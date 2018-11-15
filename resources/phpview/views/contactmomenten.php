<?php if (count($contactmomenten) === 0): ?>
    <p>Geen <?= $this->escape(strtolower($caption)); ?></p>
<?php else: ?>
    <table>
        <caption><a href="#" onclick="if (this.closest('table').querySelector('tbody.collapsed') != null) { this.closest('table').querySelector('tbody.collapsed').className = null; } else { this.closest('table').querySelector('tbody').className = 'collapsed'; }"><?= $this->escape($caption); ?></a></caption>
        <thead>
        <tr>
            <th width="30">KW</th>
            <th width="30">BW</th>
            <th width="80">Dag</th>
            <th width="80">Starttijd</th>
            <th width="80">Eindtijd</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody class="collapsed">
        <?php foreach ($contactmomenten as $contactmoment): ?>
            <?php if (strtotime($contactmoment->starttijd) <= time() && strtotime($contactmoment->starttijd) >= time()): ?>
                <tr class="active">
            <?php elseif (strtotime($contactmoment->eindtijd) <= time()): ?>
                <tr class="past">
            <?php else: ?>
                <tr>
            <?php endif; ?>
            <td><?= $this->escape($contactmoment->kalenderweek); ?></td>
            <td><?= $this->escape($contactmoment->blokweek); ?></td>
            <td><?= $this->escape(strftime('%A', strtotime($contactmoment->starttijd))); ?></td>
            <td><?= $this->escape(date('H:i', strtotime($contactmoment->starttijd))); ?></td>
            <td><?= $this->escape(date('H:i', strtotime($contactmoment->eindtijd))); ?></td>
            <td><a href="<?= $this->url('/feedback/%s', $contactmoment->id); ?>" target="_blank"><img src="<?= $this->url('/rating/%s', $contactmoment->retrieveRating()??'N'); ?>" width="75" height="15" style="float: right;" /></a>
            </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
