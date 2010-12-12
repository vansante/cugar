<?php if ($config->Mode1s->count()) : ?>
    <ul class="sub-list">
    <?php foreach ($config->Mode1s as $mode1) : ?>
        <li><?php echo link_to($mode1->__toString(), 'mode1_edit', $mode1) ?></li>
    <?php endforeach ?>
    </ul>
<?php else : ?>
    <em>None</em>
<?php endif;