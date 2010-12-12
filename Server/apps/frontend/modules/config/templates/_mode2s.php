<?php if ($config->Mode2s->count()) : ?>
<ul class="sub-list">
    <?php foreach ($config->Mode2s as $mode2) : ?>
        <li><?php echo link_to($mode2->__toString(), 'mode2_edit', $mode2) ?></li>
    <?php endforeach ?>
    </ul>
<?php else : ?>
    <em>None</em>
<?php endif;