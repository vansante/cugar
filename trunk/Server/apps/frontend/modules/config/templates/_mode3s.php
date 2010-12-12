<?php if ($config->Mode3s->count()) : ?>
    <ul class="sub-list">
    <?php foreach ($config->Mode3s as $mode3) : ?>
        <li><?php echo link_to($mode3->__toString(), 'mode1_edit', $mode3) ?></li>
    <?php endforeach ?>
    </ul>
<?php else : ?>
    <em>None</em>
<?php endif;