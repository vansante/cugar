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

        <dt>Internet configuration</dt>
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
</div>

<script type="text/javascript">
$(function() {
    $('#basic_settings_form input[name=basic_settings_type]').click(function() {
        if (this.value.toLowerCase() == 'static') {
            $('.basic_settings_subform_static').slideDown();
            $('.basic_settings_subform_static input').removeAttr('disabled');
        } else {
            $('.basic_settings_subform_static').slideUp();
            $('.basic_settings_subform_static input').attr('disabled', 'disabled');
        }
    });

    var type = $("#basic_settings_form input[name='basic_settings_type']:checked").val();
    if (type != 'static') {
        $('.basic_settings_subform_static').hide();
        $('.basic_settings_subform_static input').attr('disabled', 'disabled');
    }
});

cg.basic.settings.clickHandler = function() {
        cg.basic.settings.load();
    };

    //XML Module: System
    cg.basic.settings.load = function() {
        cg.data.system = {};

        //Handle XML loading
        cg.doAction({
            url: 'testxml/system.xml',
            module: 'System',
            page: 'getconfig',
            error_element: $('#basic_settings_form_error'),
            content_id: 'cp_basic_settings_settings',
            successFn: function(json) {
                cg.data.system = json.system;

                cg.basic.settings.loadForm();
            }
        });
    };

    cg.basic.settings.loadForm = function() {
        var data = cg.data.system;
        cg.resetForm('basic_settings_form');

        $('#basic_settings_hostname').val(data.hostname);
        $('#basic_settings_domain').val(data.domain);
        if (data.dnsservers.dnsserver) {
            if ($.isArray(data.dnsservers.dnsserver)) {
                $.each(data.dnsservers.dnsserver, function(i, dns) {
                    if (i <= 2) {
                        $('#basic_settings_dns'+(i+1)).val(dns.ip);
                    }
                });
            } else {
                $('#basic_settings_dns1').val(data.dnsservers.dnsserver.ip);
            }
        }
        $('#basic_settings_dnsoverride').attr('checked', data.dnsoverride.toLowerCase() == 'allow');
    };

    $(function(){
        //Handler for submitting the form
        $('#basic_settings_form').submit(function() {
            cg.doFormAction({
                url: 'testxml/system.xml',
                form_id: 'basic_settings_form',
                error_element: $('#basic_settings_form_error'),
                successFn: function(json) {
                    cg.data.system = json.system;
                    cg.basic.settings.loadForm();
                }
            });
            return false;
        });
    });
</script>
