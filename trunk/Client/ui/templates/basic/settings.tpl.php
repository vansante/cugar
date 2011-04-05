<h2 class="help_anchor"><a class="open_all_help" rel="cp_basic_settings"></a>Basic settings</h2>

<form id="basic_settings_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="basic_settings_form_error">
    </div>

    <input type="hidden" name="module" value="settings"/>
    <input type="hidden" name="page" value="save" id="basic_settings_form_page"/>

    <h3>Security</h3>
    
    <dl>
        <dt><label for="basic_settings_password">New password</label></dt>
        <dd>
            <input type="text" size="40" name="basic_settings_password" id="basic_settings_password"/>
        </dd>
    </dl>

    <p style="clear: both;"></p>
    
    <h3>Internet settings</h3>

    <dl>
        <dt><label for="basic_settings_hostname">Hostname</label></dt>
        <dd>
            <input type="text" size="40" name="basic_settings_hostname" id="basic_settings_hostname"/>
        </dd>

        <dt><label for="basic_settings_type">Internet configuration</label></dt>
        <dd>
            <input name="basic_settings_type" type="radio" id="basic_settings_type_dhcp" value="dhcp"/>
            <label for="basic_settings_type_dhcp">Get an IP address automaticly (DHCP)</label>
            <br/>
            <input name="basic_settings_type" type="radio" id="basic_settings_type_static" value="static"/>
            <label for="basic_settings_type_static">Specify an IP address</label>
        </dd>

        <dt class="basic_settings_subform_static">Static IP configuration</dt>
        <dd class="basic_settings_subform_static">
            <dl class="form_sub">
                <dt><label for="basic_settings_static_ipaddr">IP address</label></dt>
                <dd>
                    <input name="basic_settings_static_ipaddr" type="text" size="12" id="basic_settings_static_ipaddr" />
                </dd>

                <dt><label for="basic_settings_static_subnet_mask">Subnet mask</label></dt>
                <dd>
                    <input name="basic_settings_static_subnet_mask" type="text" size="12" id="basic_settings_static_subnet_mask" />
                </dd>

                <dt><label for="basic_settings_static_default_gateway">Default gateway</label></dt>
                <dd>
                    <input name="basic_settings_static_default_gateway" type="text" size="12" id="basic_settings_static_default_gateway" />
                </dd>

                <dt><label for="basic_settings_static_dns_server_1">DNS servers</label></dt>
                <dd>
                    <input name="basic_settings_static_dns_server_1" type="text" size="12" id="basic_settings_static_dns_server_1"/><br/>
                    <input name="basic_settings_static_dns_server_2" type="text" size="12" id="basic_settings_static_dns_server_2"/>
                </dd>
            </dl>
        </dd>
    </dl>

    <p style="clear: both;"></p>

    <h3>Wireless settings</h3>

    <dl>
        <dt><label for="basic_settings_wl_channel">Channel</label></dt>
        <dd>
            <select name="basic_settings_wl_channel" id="basic_settings_channel">
                <option value="auto">Auto</option>
                <?php for ($i = 0; $i < 14; $i++) : ?>
                <option value="<?=$i?>"><?=$i?></option>
                <?php endfor ?>
            </select>
        </dd>

        <dt><label for="basic_settings_wl_mode">Wireless mode</label></dt>
        <dd>
            <select name="basic_settings_wl_mode" id="basic_settings_wl_mode">
                <option value="auto">Auto</option>
                <option value="b">Wireless B</option>
                <option value="g">Wireless G</option>
                <option value="n">Wireless N</option>
            </select>
        </dd>
        
        <dt><input type="submit" value="Save" id="basic_settings_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_basic_settings_password">Set a new password for these management pages</div>
    <div class="help" id="help_basic_settings_hostname">Hostname for the accesspoint, without the domain part. e.g. "accesspoint"</div>
    <div class="help" id="help_basic_settings_type">Choose the type of IP configuration you want to use</div>
    <div class="help" id="help_basic_settings_static_ipaddr">Enter the IP address of the interface in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_static_subnet_mask">Enter the subnet mask of the interface in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_static_default_gateway">Enter the IP address of the default gateway in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_static_dns_server_1">Please enter the IPs of the DNS servers of your ISP in the following format: xxx.xxx.xxx.xxx</div>
    <div class="help" id="help_basic_settings_wl_channel">Please select the channel on which your accesspoint should transmit</div>
    <div class="help" id="help_basic_settings_wl_mode">Please select the mode your accesspoint should run in</div>
</div>

