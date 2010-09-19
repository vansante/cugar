<script type="text/javascript">
    cg.system.genset.clickHandler = function() {
        cg.system.genset.load();
    };

    //XML Module: System
    cg.system.genset.load = function() {
        cg.data.system = {};
        
        //Handle XML loading
        cg.doAction({
            url: 'testxml/system.xml',
            module: 'System',
            page: 'getconfig',
            error_element: $('#system_genset_form_error'),
            content_id: 'cp_system_genset_genset',
            successFn: function(json) {
                cg.data.system = json.system;

                cg.system.genset.loadForm();
            }
        });
    };

    cg.system.genset.loadForm = function() {
        var data = cg.data.system;
        cg.resetForm('system_genset_form');

        $('#system_genset_hostname').val(data.hostname);
        $('#system_genset_domain').val(data.domain);
        if (data.dnsservers.dnsserver) {
            if ($.isArray(data.dnsservers.dnsserver)) {
                $.each(data.dnsservers.dnsserver, function(i, dns) {
                    if (i <= 2) {
                        $('#system_genset_dns'+(i+1)).val(dns.ip);
                    }
                });
            } else {
                $('#system_genset_dns1').val(data.dnsservers.dnsserver.ip);
            }
        }
        $('#system_genset_dnsoverride').attr('checked', data.dnsoverride.toLowerCase() == 'allow');
    };

    $(function(){
        //Handler for submitting the form
        $('#system_genset_form').submit(function() {
            cg.doFormAction({
                url: 'testxml/system.xml',
                form_id: 'system_genset_form',
                error_element: $('#system_genset_form_error'),
                successFn: function(json) {
                    cg.data.system = json.system;
                    cg.system.genset.loadForm();
                }
            });
            return false;
        });

        $('#system_genset_username').val('admin');
        $('#system_genset_username').attr('disabled', 'disabled');
        $('#system_genset_password1').attr('disabled', 'disabled');
        $('#system_genset_password2').attr('disabled', 'disabled');
        $('#system_genset_change_user').click(function(){
            if (this.checked) {
                $('#system_genset_username').removeAttr('disabled');
                $('#system_genset_password1').removeAttr('disabled');
                $('#system_genset_password2').removeAttr('disabled');
            } else {
                $('#system_genset_username').attr('disabled', 'disabled');
                $('#system_genset_password1').attr('disabled', 'disabled');
                $('#system_genset_password2').attr('disabled', 'disabled');
            }
        });
    });
</script>
