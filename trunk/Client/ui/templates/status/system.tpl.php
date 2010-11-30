<h2>System status</h2>

<p class="intro">An overview of the system settings.</p>

<div class="form-error" id="status_system_error">
</div>

<dl class="form">

    <dt>Name</dt>
    <dd>
        <span id="status_system_name"></span>
    </dd>

    <dt>System version</dt>
    <dd>
        <span id="status_system_version"></span>
    </dd>

    <dt>Uptime</dt>
    <dd>
        <span id="status_system_uptime"></span>
    </dd>

    <dt>CPU load</dt>
    <dd>
        <dl class="form_sub">
            <dt>1 minute average</dt>
            <dd><span id="status_system_cpu_1"></span> %</dd>

            <dt>5 minute average</dt>
            <dd><span id="status_system_cpu_5"></span> %</dd>

            <dt>15 minute average</dt>
            <dd><span id="status_system_cpu_15"></span> %</dd>
        </dl>
    </dd>

    <dt>Memory usage</dt>
    <dd>
        <dl class="form_sub">
            <dt>Total</dt>
            <dd><span id="status_system_memory_total"></span> MiB</dd>

            <dt>In use</dt>
            <dd><span id="status_system_memory_inuse"></span> MiB</dd>
        </dl>
    </dd>
</dl>

<p style="clear: both;"></p>

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
            content_id: 'cp_status_system',
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
