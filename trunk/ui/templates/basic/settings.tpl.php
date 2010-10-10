<script type="text/javascript">
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

        $('#basic_settings_username').val('admin');
        $('#basic_settings_username').attr('disabled', 'disabled');
        $('#basic_settings_password1').attr('disabled', 'disabled');
        $('#basic_settings_password2').attr('disabled', 'disabled');
        $('#basic_settings_change_user').click(function(){
            if (this.checked) {
                $('#basic_settings_username').removeAttr('disabled');
                $('#basic_settings_password1').removeAttr('disabled');
                $('#basic_settings_password2').removeAttr('disabled');
            } else {
                $('#basic_settings_username').attr('disabled', 'disabled');
                $('#basic_settings_password1').attr('disabled', 'disabled');
                $('#basic_settings_password2').attr('disabled', 'disabled');
            }
        });
    });
</script>
