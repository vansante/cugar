<h2 class="help_anchor"><a class="open_all_help" rel="cp_interfaces_lan_lan"></a>LAN interface</h2>

<p class="intro">In the LAN section, it is possible to change the IP address and the netmask (in CIDR notation) of the device internal interface. The system must be rebooted in order to apply the changes as suggested after pressing the "Save" button.</p>

<div class="warning">
    <h3>Warning:</h3>
    <p>After you click "Save", you must reboot your firewall for changes to take effect. You may also have to do one or more of the following steps before you can access your firewall again:</p>
    <ul>
        <li>Change the IP address of your computer</li>
        <li>Renew its DHCP lease</li>
        <li>Access the web interface with the new IP address</li>
    </ul>
</div>

<form id="interfaces_lan_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="interfaces_lan_form_error">
    </div>

    <input type="hidden" name="module" value="Lan"/>
    <input type="hidden" name="page" value="save" id="interfaces_lan_form_page"/>

    <dl>
        <dt><label for="interfaces_lan_ipaddr">IP Address</label></dt>
        <dd>
            <input name="interfaces_lan_ipaddr" type="text" size="12" id="interfaces_lan_ipaddr" />
        </dd>

        <dt><label for="interfaces_lan_subnetmask">Subnet mask</label></dt>
        <dd>
            <input name="interfaces_lan_subnetmask" type="text" size="12" id="interfaces_lan_subnetmask" />
        </dd>

        <dt><label for="interfaces_lan_mtu">MTU</label></dt>
        <dd>
            <input name="interfaces_lan_mtu" type="text" size="4" id="interfaces_lan_mtu" />
        </dd>
        
        <dt><input type="submit" value="Save" id="interfaces_lan_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_interfaces_lan_ipaddr">Enter an IP address in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_interfaces_lan_subnetmask">Enter a subnet mask in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_interfaces_lan_mtu">Maximum transmission unit. Leave blank for default</div>
</div>