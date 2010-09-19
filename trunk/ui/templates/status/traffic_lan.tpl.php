<h2>Traffic on LAN interface</h2>

<p class="intro">You can view the traffic statistics for the LAN interface here.</p>

<?
$this->status_traffic_id = 'lan';
include $this->template('status/traffic_table.tpl.php');
?>