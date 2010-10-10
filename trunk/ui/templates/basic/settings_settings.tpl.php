<h2 class="help_anchor"><a class="open_all_help" rel="cp_basic_settings_settings"></a>Basic settings</h2>

<form id="basic_settings_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="basic_settings_form_error">
    </div>

    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="savegeneralsettings" id="basic_settings_form_page"/>
    
    <dl>
        <dt><label for="basic_settings_hostname">Hostname</label></dt>
        <dd>
            <input type="text" size="40" name="basic_settings_hostname" id="basic_settings_hostname"/>
        </dd>

        <dt><label for="basic_settings_domain">Domain name</label></dt>
        <dd>
            <input type="text" size="25" name="basic_settings_domain" id="basic_settings_domain"/>
        </dd>


        <dt><label for="basic_settings_type">Internet configuration</label></dt>
        <dd>
            <input name="basic_settings_type" type="radio" id="basic_settings_type_dhcp" value="dhcp"/>
            <label for="basic_settings_type_dhcp">Get an IP address automaticly (DHCP)</label>
            <br/>
            <input name="basic_settings_type" type="radio" id="basic_settings_type_static" value="static"/>
            <label for="basic_settings_type_static">Specify an IP address</label>
        </dd>

        <dt>DHCP configuration</dt>
        <dd>
            <dl class="form_sub" id="basic_settings_subform_dhcp">
                <dt><label for="basic_settings_dhcp_hostname">Client hostname</label></dt>
                <dd>
                    <input name="basic_settings_dhcp_hostname" type="text" id="basic_settings_dhcp_hostname" />
                </dd>
            </dl>
        </dd>

        <dt>Static IP configuration</dt>
        <dd>
            <dl class="form_sub" id="basic_settings_subform_static">
                <dt><label for="basic_settings_static_ipaddr">IP address</label></dt>
                <dd>
                    <input name="basic_settings_static_ipaddr" type="text" size="12" id="basic_settings_static_ipaddr" />
                </dd>

                <dt><label for="basic_settings_static_subnetmask">Subnet mask</label></dt>
                <dd>
                    <input name="basic_settings_static_subnetmask" type="text" size="12" id="basic_settings_static_subnetmask" />
                </dd>

                <dt><label for="basic_settings_static_gateway">Default gateway</label></dt>
                <dd>
                    <input name="basic_settings_static_gateway" type="text" size="12" id="basic_settings_static_gateway" />
                </dd>

                <dt><label for="basic_settings_dns1">DNS servers</label></dt>
                <dd>
                    <input name="basic_settings_dns1" type="text" size="12" id="basic_settings_dns1"/><br/>
                    <input name="basic_settings_dns2" type="text" size="12" id="basic_settings_dns2"/>
                </dd>
            </dl>
        </dd>
        

        
        <dt><input type="submit" value="Save" id="basic_settings_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_basic_settings_hostname">Name of the firewall host, without domain part. e.g. "firewall"</div>
    <div class="help" id="help_basic_settings_domain">e.g. mycorp.com</div>
    <div class="help" id="help_basic_settings_dns1">IP addresses; these are also used for the DHCP service, DNS forwarder and for PPTP VPN clients </div>
    <div class="help" id="help_basic_settings_type">Choose the type of IP configuration you want to use</div>
    <div class="help" id="help_basic_settings_static_subnetmask">Enter the subnet mask of the interface in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_static_ipaddr">Enter the IP address of the interface in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_static_gateway">Enter the IP address of the default gateway in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_dhcp_hostname">The value in this field is sent as the DHCP client identifier and hostname when requesting a DHCP lease. Some ISPs may require this (for client identification).</div>
</div>

<script type="text/javascript">
$(function() {
    $('input[name=basic_settings_type]').click(function() {
        if (this.value.toLowerCase() == 'static') {
            $('#basic_settings_subform_dhcp input').attr('disabled', 'disabled');
            $('#basic_settings_subform_static input').removeAttr('disabled');
        } else {
            $('#basic_settings_subform_dhcp input').removeAttr('disabled');
            $('#basic_settings_subform_static input').attr('disabled', 'disabled');
        }
    });
});
</script>