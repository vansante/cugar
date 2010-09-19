<script type="text/javascript">
    cg.status.ifaces.clickHandler = function() {
        cg.status.ifaces.load();
    };

    cg.status.ifaces.load = function() {
        //Handle XML loading
        cg.doAction({
            url: 'testxml/status_interfaces.xml',
            module: 'AssignInterfaces',
            page: 'getstatus',
            error_element: [
                $('#status_ifaces_wan_error'),
                $('#status_ifaces_lan_error'),
                $('#status_ifaces_ext_error')
            ],
            content_id: ['cp_status_ifaces_wan', 'cp_status_ifaces_lan', 'cp_status_ifaces_ext'],
            successFn: function(json) {
                $('#status_ifaces_wan_device').html(json.interfaces.wan.device);
                $('#status_ifaces_wan').html('<pre>'+json.interfaces.wan.status+'</pre>');
                $('#status_ifaces_lan_device').html(json.interfaces.lan.device);
                $('#status_ifaces_lan').html('<pre>'+json.interfaces.lan.status+'</pre>');
                $('#status_ifaces_ext_device').html(json.interfaces.ext.device);
                $('#status_ifaces_ext').html('<pre>'+json.interfaces.ext.status+'</pre>');
            }
        });
    };
</script>