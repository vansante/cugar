<script type="text/javascript">
$(function() {
    $('#basic_settings_form input[name=basic_settings_type]').click(function() {
        if (this.value.toLowerCase() == 'static') {
            $('.basic_settings_subform_static').slideDown();
            $('.basic_settings_subform_static input').removeAttr('disabled');
        } else {
            $('.basic_settings_subform_static').hide();
            $('.basic_settings_subform_static input').attr('disabled', 'disabled');
        }
    });
});

cg.basic.clickHandler = function() {
    cg.basic.settings.load();
};

cg.basic.settings.load = function() {
    cg.data.basic_settings = {};

    cg.doAction({
        url: 'test_xml/basic_settings.xml',
        module: 'settings',
        page: 'get',
        error_element: $('#basic_settings_form_error'),
        content_id: 'cp_basic_settings_settings',
        successFn: function(json) {
            cg.data.basic_settings = json.basic_settings;

            cg.basic.settings.loadForm();
        }
    });
};

cg.basic.settings.loadForm = function() {
    var data = cg.data.basic_settings;
    cg.resetForm('basic_settings_form');

    $('#basic_settings_hostname').val(data.hostname);

    if (data.type.toLowerCase() == 'dhcp') {
        $('#basic_settings_type_dhcp').attr('checked', 'checked');

        $('.basic_settings_subform_static').hide();
        $('.basic_settings_subform_static input').attr('disabled', 'disabled');
    } else {
        $('#basic_settings_type_static').attr('checked', 'checked');

        $('.basic_settings_subform_static').slideDown();
        $('.basic_settings_subform_static input').removeAttr('disabled');

        $('#basic_settings_static_ipaddr').val(data['static'].ipaddr);
        $('#basic_settings_static_subnet_mask').val(data['static'].subnet_mask);
        $('#basic_settings_static_default_gateway').val(data['static'].default_gateway);
        $('#basic_settings_static_dns_server_1').val(data['static'].dns_server_1);
        $('#basic_settings_static_dns_server_2').val(data['static'].dns_server_2);
    }
};

$(function(){
    //Handler for submitting the form
    $('#basic_settings_form').submit(function() {
        cg.doFormAction({
            url: 'test_xml/basic_settings.xml',
            form_id: 'basic_settings_form',
            error_element: $('#basic_settings_form_error'),
            successFn: function(json) {
                cg.data.basic_settings = json.basic_settings;
                cg.basic.settings.loadForm();
            }
        });
        return false;
    });
});
</script>