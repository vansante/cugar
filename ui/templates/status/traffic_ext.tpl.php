<h2>Traffic on EXT interface</h2>

<p class="intro">You can view the traffic statistics for the EXT interface here.</p>

<?
$this->status_traffic_id = 'ext';
include $this->template('status/traffic_table.tpl.php');
?>