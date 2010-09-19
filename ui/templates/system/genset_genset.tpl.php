<h2 class="help_anchor"><a class="open_all_help" rel="cp_system_genset_genset"></a>General settings</h2>

<p class="intro">The General Settings screen allows you to control some general parameters of your device.</p>

<form id="system_genset_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="system_genset_form_error">
    </div>

    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="savegeneralsettings" id="system_genset_form_page"/>
    
    <dl>
        <dt><label for="system_genset_hostname">Hostname</label></dt>
        <dd>
            <input type="text" size="40" name="system_genset_hostname" id="system_genset_hostname"/>
        </dd>

        <dt><label for="system_genset_domain">Domain</label></dt>
        <dd>
            <input type="text" size="25" name="system_genset_domain" id="system_genset_domain"/>
        </dd>

        <dt><label for="system_genset_dns1">DNS servers</label></dt>
        <dd>
            <input name="system_genset_dns1" type="text" size="12" id="system_genset_dns1"/><br/>
            <input name="system_genset_dns2" type="text" size="12" id="system_genset_dns2"/><br/>
            <input name="system_genset_dns3" type="text" size="12" id="system_genset_dns3"/><br/>
        </dd>

        <dt><label for="system_genset_dnsoverride">Override DNS server</label></dt>
        <dd>
            <input type="checkbox" name="system_genset_dnsoverride" id="system_genset_dnsoverride" value="true"/>
        </dd>

        <dt><label for="system_genset_change_user">Change username/password</label></dt>
        <dd>
            <input type="checkbox" name="system_genset_change_user" id="system_genset_change_user" value="true"/>
        </dd>

        <dt><label for="system_genset_username">Username</label></dt>
        <dd>
            <input type="text" name="system_genset_username" id="system_genset_username"/>
        </dd>

        <dt><label for="system_genset_password1">Password</label></dt>
        <dd>
            <input type="password" name="system_genset_password1" id="system_genset_password1"/>
        </dd>

        <dt><label for="system_genset_password2">Password (repeat)</label></dt>
        <dd>
            <input type="password" name="system_genset_password2" id="system_genset_password2"/>
        </dd>
        
        <dt><input type="submit" value="Save" id="system_genset_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_system_genset_hostname">Name of the firewall host, without domain part. e.g. "firewall"</div>
    <div class="help" id="help_system_genset_domain">e.g. mycorp.com</div>
    <div class="help" id="help_system_genset_dns1">IP addresses; these are also used for the DHCP service, DNS forwarder and for PPTP VPN clients </div>
    <div class="help" id="help_system_genset_dnsoverride">Allow DNS server list to be overridden by DHCP/PPP on WAN<br>If this option is set, the system will use DNS servers assigned by a DHCP/PPP server on WAN for its own purposes (including the DNS forwarder). They will not be assigned to DHCP and PPTP VPN clients, though.</div>
    <div class="help" id="help_system_genset_username">If you want to change the username for accessing the web interface, enter it here. </div>
    <div class="help" id="help_system_genset_password1">If you want to change the password for accessing the web interface, enter it here (twice). </div>
</div>