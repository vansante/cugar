<?php if ($mode3->DhcpServers->count()) : ?>
    <ul class="sub-list">
    <?php foreach ($mode3->DhcpServers as $server) : ?>
        <li><?php echo link_to($server->__toString(), 'dhcp_server_edit', $server) ?></li>
    <?php endforeach ?>
    </ul>
<?php else : ?>
    <em>None</em>
<?php endif;