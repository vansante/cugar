<script type="text/javascript">
    cg.interfaces.<?=$this->ipconfig_iface?>.clickHandler = function() {
        cg.interfaces.<?=$this->ipconfig_iface?>.load();
    };

    cg.interfaces.<?=$this->ipconfig_iface?>.load = function() {
        cg.data.interface_<?=$this->ipconfig_iface?> = {};

        //Handle XML loading
        cg.doAction({
            url: 'testxml/iface_<?=$this->ipconfig_iface?>.xml',
            module: '<?=$this->ipconfig_module?>',
            page: 'getconfig',
            error_element: $('#<?=$this->ipconfig_id?>_form_error'),
            content_id: 'cp_<?=$this->ipconfig_id?>',
            successFn: function(json) {
                cg.data.interface_<?=$this->ipconfig_iface?> = json['interface'];
                cg.interfaces.<?=$this->ipconfig_iface?>.loadForm();
            }
        });
    };

    cg.interfaces.<?=$this->ipconfig_iface?>.loadForm = function() {
        var data = cg.data.interface_<?=$this->ipconfig_iface?>;
        cg.resetForm('<?=$this->ipconfig_id?>_form');

        $('#<?=$this->ipconfig_id?>_mac').val(data.mac);
        $('#<?=$this->ipconfig_id?>_mtu').val(data.mtu);
        if (data.ipaddr.toLowerCase() == 'dhcp') {
            $('#<?=$this->ipconfig_id?>_type_dhcp').attr('checked', 'checked');
            $('#<?=$this->ipconfig_id?>_subform_dhcp input').removeAttr('disabled');
            $('#<?=$this->ipconfig_id?>_subform_static input').attr('disabled', 'disabled');
            $('#<?=$this->ipconfig_id?>_static_dhcp_hostname').val(data.dhcphostname);
        } else {
            $('#<?=$this->ipconfig_id?>_subform_dhcp input').attr('disabled', 'disabled');
            $('#<?=$this->ipconfig_id?>_subform_static input').removeAttr('disabled');
            $('#<?=$this->ipconfig_id?>_type_static').attr('checked', 'checked');
            $('#<?=$this->ipconfig_id?>_static_ipaddr').val(data.ipaddr);
            $('#<?=$this->ipconfig_id?>_static_subnetmask').val(data.subnet);
            $('#<?=$this->ipconfig_id?>_static_gateway').val(data.gateway);
        }
    };

    $(function() {
        //XML Module: AssignInterfaces
        $('#<?=$this->ipconfig_id?>_form').submit(function() {
            cg.doFormAction({
                url: 'testxml/iface_<?=$this->ipconfig_iface?>.xml',
                form_id: '<?=$this->ipconfig_id?>_form',
                error_element: $('#<?=$this->ipconfig_id?>_form_error'),
                successFn: function(json) {
                    cg.data.interface_<?=$this->ipconfig_iface?> = json['interface'];
                    cg.interfaces.<?=$this->ipconfig_iface?>.loadForm();
                }
            });
            return false;
        });
    });
</script>