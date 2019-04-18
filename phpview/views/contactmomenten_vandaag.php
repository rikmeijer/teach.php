<?php
/**
 * @var \rikmeijer\Teach\Beans\Contactmoment[] $contactmomenten
 */

if (count($contactmomenten) === 0) : ?>
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
        </tbody>
    </table>
<?php endif; ?>
