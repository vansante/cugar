<script type="text/javascript">
    cg.interfaces.lan.clickHandler = function() {
        cg.interfaces.lan.load();
    };

    cg.interfaces.lan.load = function() {
        cg.data.interface_lan = {};

        //Handle XML loading
        cg.doAction({
            url: 'testxml/iface_lan.xml',
            module: 'Lan',
            page: 'getconfig',
            error_element: $('#interfaces_lan_form_error'),
            content_id: 'cp_interfaces_lan_lan',
            successFn: function(json) {
                cg.data.interface_lan = json['interface'];
                cg.interfaces.lan.loadForm();
            }
        });
    };

    cg.interfaces.lan.loadForm = function() {
        var data = cg.data.interface_lan;
        cg.resetForm('interfaces_lan_form');

        $('#interfaces_lan_ipaddr').val(data.ipaddr);
        $('#interfaces_lan_subnetmask').val(data.subnet);
        $('#interfaces_lan_mtu').val(data.mtu);
    };

    $(function() {
        //XML Module: AssignInterfaces
        $('#interfaces_lan_form').submit(function() {
            cg.doFormAction({
                form_id: 'interfaces_lan_form',
                error_element: $('#interfaces_lan_form_error'),
                successFn: function(json) {
                    cg.data.interface_lan = json['interface'];
                    cg.interfaces.lan.loadForm();
                }
            });
            return false;
        });
    });
</script>