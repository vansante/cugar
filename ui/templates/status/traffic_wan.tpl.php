<h2>Traffic on WAN interface</h2>

<p class="intro">You can view the traffic statistics for the WAN interface here.</p>

<?
$this->status_traffic_id = 'wan';
include $this->template('status/traffic_table.tpl.php');
?>