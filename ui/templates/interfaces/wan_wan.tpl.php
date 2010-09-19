<h2 class="help_anchor"><a class="open_all_help" rel="cp_interfaces_wan_wan"></a>WAN interface</h2>

<p class="intro">In the WAN section, it is possible to set up all the parameters for the WAN interface. The WAN Interface can be a static IP address or a DHCP address as detailed in the following. On the basis of the connection type selected, the related sub panel must be filled.</p>

<?
$this->ipconfig_id = 'interfaces_wan';
$this->ipconfig_module = 'Wan';
include $this->template('interfaces/forms/ipconfig.tpl.php');
?>