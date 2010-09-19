<script type="text/javascript">
    cg.status.dhcp.clickHandler = function() {
        cg.status.dhcp.load();
    };

    //XML Module: Dhcpd
    cg.status.dhcp.load = function() {
        cg.data.status_dhcp_leases = {};

        //Handle XML loading
        cg.doAction({
            url: 'testxml/status_dhcp.xml',
            module: 'Dhcpd',
            page: 'getstatus',
            error_element: $('#status_dhcp_table_error'),
            content_id: 'cp_status_dhcp_dhcp',
            successFn: function(json) {
                if (json.dhcp_status.lease) {
                    var lease = json.dhcp_status.lease;
                    if ($.isArray(lease)) {
                        $.each(lease, function(i, rule) {
                            cg.data.status_dhcp_leases[i] = rule;
                        });
                    } else {
                        //One rule
                        cg.data.status_dhcp_leases[0] = lease;
                    }
                }
                cg.status.dhcp.buildTable();
            }
        });
    };

    cg.status.dhcp.buildTable = function() {
        //Clear the current table data to (re)load it
        $('#status_dhcp_tbody').empty();
        
        $.each(cg.data.status_dhcp_leases, function(id, rule) {
            cg.status.dhcp.addRule(rule);
        });
    };

    //Add a rule to the table
    cg.status.dhcp.addRule = function(rule) {
        var tblstring = '<tr>'+
            '<td>'+rule.ip+'</td>'+
            '<td>'+rule.mac+'</td>'+
            '<td>'+rule.hostname+'</td>'+
            '<td>'+rule.start+'</td>'+
            '<td>'+rule.end+'</td>'+
            '</tr>';
        $('#status_dhcp_tbody').append(tblstring);
    };
</script>