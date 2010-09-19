<script type="text/javascript">
    cg.status.system.clickHandler = function() {
        cg.status.system.load();
    };

    cg.status.system.load = function() {
        $('#status_system_download').hide();
        //Handle XML loading
        cg.doAction({
            url: 'testxml/status_system.xml',
            module: 'System',
            page: 'getstatus',
            error_element: $('#status_system_error'),
            content_id: 'cp_status_system_system',
            successFn: function(json) {
                json = json.system;
                $('#status_system_name').html(json.name);
                $('#status_system_version').html(json.version);
                $('#status_system_uptime').html(json.uptime);
                $('#status_system_cpu_1').html(json.cpu.avg1);
                $('#status_system_cpu_5').html(json.cpu.avg5);
                $('#status_system_cpu_15').html(json.cpu.avg15);
                $('#status_system_memory_total').html(json.memory.total);
                $('#status_system_memory_inuse').html(json.memory.used);
            }
        });
    };
</script>
