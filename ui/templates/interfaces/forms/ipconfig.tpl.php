<form id="<?=$this->ipconfig_id?>_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="<?=$this->ipconfig_id?>_form_error">
    </div>

    <input type="hidden" name="module" value="<?=$this->ipconfig_module?>"/>
    <input type="hidden" name="page" value="save" id="<?=$this->ipconfig_id?>_form_page"/>

    <dl>
        <dt><label for="<?=$this->ipconfig_id?>_mac">MAC address</label></dt>
        <dd>
            <input name="<?=$this->ipconfig_id?>_mac" type="text" id="<?=$this->ipconfig_id?>_mac" />
        </dd>

        <dt><label for="<?=$this->ipconfig_id?>_mtu">MTU</label></dt>
        <dd>
            <input name="<?=$this->ipconfig_id?>_mtu" type="text" size="4" id="<?=$this->ipconfig_id?>_mtu" />
        </dd>

        <dt><label for="<?=$this->ipconfig_id?>_type">Type</label></dt>
        <dd>
            <input name="<?=$this->ipconfig_id?>_type" type="radio" id="<?=$this->ipconfig_id?>_type_static" value="static"/>
            <label for="<?=$this->ipconfig_id?>_type_static">Static</label>
            <input name="<?=$this->ipconfig_id?>_type" type="radio" id="<?=$this->ipconfig_id?>_type_dhcp" value="dhcp"/>
            <label for="<?=$this->ipconfig_id?>_type_dhcp">DHCP</label>
        </dd>

        <dt>Static IP configuration</dt>
        <dd>
            <dl class="form_sub" id="<?=$this->ipconfig_id?>_subform_static">
                <dt><label for="<?=$this->ipconfig_id?>_static_ipaddr">IP address</label></dt>
                <dd>
                    <input name="<?=$this->ipconfig_id?>_static_ipaddr" type="text" size="12" id="<?=$this->ipconfig_id?>_static_ipaddr" />
                </dd>

                <dt><label for="<?=$this->ipconfig_id?>_static_subnetmask">Subnet mask</label></dt>
                <dd>
                    <input name="<?=$this->ipconfig_id?>_static_subnetmask" type="text" size="12" id="<?=$this->ipconfig_id?>_static_subnetmask" />
                </dd>

                <dt><label for="<?=$this->ipconfig_id?>_static_gateway">Default gateway</label></dt>
                <dd>
                    <input name="<?=$this->ipconfig_id?>_static_gateway" type="text" size="12" id="<?=$this->ipconfig_id?>_static_gateway" />
                </dd>
            </dl>
        </dd>
        <dt>DHCP configuration</dt>
        <dd>
            <dl class="form_sub" id="<?=$this->ipconfig_id?>_subform_dhcp">
                <dt><label for="<?=$this->ipconfig_id?>_dhcp_hostname">Client hostname</label></dt>
                <dd>
                    <input name="<?=$this->ipconfig_id?>_dhcp_hostname" type="text" id="<?=$this->ipconfig_id?>_dhcp_hostname" />
                </dd>
            </dl>
        </dd>

        <dt><input type="submit" value="Save" id="<?=$this->ipconfig_id?>_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_<?=$this->ipconfig_id?>_mac">This field can be used to modify (spoof) the MAC address of the WAN interface (may be required with some cable connections) Enter a MAC address in the following format: xx:xx:xx:xx:xx:xx or leave blank</div>
    <div class="help" id="help_<?=$this->ipconfig_id?>_mtu">Maximum transmission unit. Leave blank for default</div>
    <div class="help" id="help_<?=$this->ipconfig_id?>_type">Choose the type of IP configuration you want to use</div>
    <div class="help" id="help_<?=$this->ipconfig_id?>_static_subnetmask">Enter the subnet mask of the interface in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_<?=$this->ipconfig_id?>_static_ipaddr">Enter the IP address of the interface in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_<?=$this->ipconfig_id?>_static_gateway">Enter the IP address of the default gateway in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_<?=$this->ipconfig_id?>_dhcp_hostname">The value in this field is sent as the DHCP client identifier and hostname when requesting a DHCP lease. Some ISPs may require this (for client identification).</div>
</div>

<script type="text/javascript">
$(function() {
    $('input[name=<?=$this->ipconfig_id?>_type]').click(function() {
        if (this.value.toLowerCase() == 'static') {
            $('#<?=$this->ipconfig_id?>_subform_dhcp input').attr('disabled', 'disabled');
            $('#<?=$this->ipconfig_id?>_subform_static input').removeAttr('disabled');
        } else {
            $('#<?=$this->ipconfig_id?>_subform_dhcp input').removeAttr('disabled');
            $('#<?=$this->ipconfig_id?>_subform_static input').attr('disabled', 'disabled');
        }
    });
});
</script>