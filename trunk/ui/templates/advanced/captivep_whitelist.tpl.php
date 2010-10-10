<h2 class="help_anchor"><a class="open_all_help" rel="cp_advanced_captivep_whitelist"></a>Website whitelist</h2>


<div class="form-error" id="advanced_captivep_whitelist_table_error">
</div>

<table id="advanced_captivep_whitelist_table">
    <thead>
        <tr>
            <th>Website</th>
            <th width="16">&nbsp;</th>
            <th width="16">&nbsp;</th>
        </tr>
    </thead>
    <tbody id="advanced_captivep_whitelist_tbody">

    </tbody>
</table>

<p>
    <a class="button" href="#advanced_captivep" id="advanced_captivep_whitelist_add_link">Add new website</a>
</p>

<form id="advanced_captivep_whitelist_form" action="ajaxserver.php" method="post" class="dialog" title="Add new website">
    <div class="form-error" id="advanced_captivep_whitelist_form_error">
    </div>

    <input type="hidden" name="module" value="CaptivePortal"/>
    <input type="hidden" name="page" value="add_website" id="advanced_captivep_whitelist_form_page"/>
    <input type="hidden" name="advanced_captivep_whitelist_id" value="" id="advanced_captivep_whitelist_id"/>

    <dl>
        <dt><label for="advanced_captivep_whitelist_website">Website</label></dt>
        <dd>
            <input type="text" name="advanced_captivep_whitelist_website" id="advanced_captivep_whitelist_website"/>
        </dd>
        
        <dt><input type="submit" value="Add website" id="advanced_captivep_whitelist_submit" class="submitbutton"/></dt>
    </dl>
</form>


<div class="help_pool">
    
</div>

<script type="text/javascript">
    //Build the rules table
    cg.advanced.captivep.whitelist.buildTable = function() {

    };

    //Add a rule to the table
    cg.advanced.captivep.whitelist.addRule = function(rule) {
        
    };

    cg.advanced.captivep.whitelist.resetForm = function() {
        cg.resetForm('advanced_captivep_whitelist_form');
    };

    //Load a rule into firewall rules form
    cg.advanced.captivep.whitelist.formLoadRule = function(rule) {
        
    };

    $(function() {
        $('#advanced_captivep_whitelist_form').dialog({
            autoOpen: false,
            resizable: false,
            width: 400,
            minHeight: 100,
            modal: true
        });

        //Click handler for adding
        $('#advanced_captivep_whitelist_add_link').click(function() {
            cg.advanced.captivep.whitelist.resetForm();
            $('#advanced_captivep_whitelist_form_page').val('add_website');
            $('#advanced_captivep_whitelist_id').val(false);
            $('#advanced_captivep_whitelist_submit').val('Add website');
            $('#advanced_captivep_whitelist_form').dialog('option', 'title', 'Add new website');
            $('#advanced_captivep_whitelist_form').dialog('open');
            return false;
        });

        //Click handler(s) for editing
        //Live handler because edit button doesn't exist on document.ready
        $('.edit_captivep_website').live('click', function() {
            var rule = cg.data.proxy_ports[$(this).attr('rel')];
            cg.advanced.captivep.whitelist.formLoadRule(rule);
            $('#advanced_captivep_whitelist_form').dialog('open');
            return false;
        });

        //Click handler for deleting rule
        $('.delete_captivep_website').live('click', function() {
            var id = $(this).attr('rel');
            cg.confirm("Are you sure?", "Are you sure you want to delete this website?", function() {
//                cg.doAction({
//                    url: 'testxml/reply.xml',
//                    module: 'Proxy',
//                    page: 'deleteport',
//                    params: {
//                        portid: id
//                    },
//                    error_element: $('#advanced_captivep_whitelist_table_error'),
//                    content_id: 'cp_advanced_captivep_whitelists',
//                    successFn: function(json) {
//                        delete cg.data.proxy_ports[id];
//                        cg.advanced.captivep.whitelist.buildTable();
//                    }
//                });
            });
            return false;
        });

        //Handler for submitting the form
        $('#advanced_captivep_whitelist_form').submit(function() {
//            cg.doFormAction({
//                url: 'testxml/',
//                form_id: 'advanced_captivep_whitelist_form',
//                error_element: $('#advanced_captivep_whitelist_form_error'),
//                successFn: function(json) {
//                    cg.data.proxy_ports[json.proxy.ports.port.id] = json.proxy.ports.port;
//                    cg.advanced.captivep.whitelist.buildTable();
//                    $('#advanced_captivep_whitelist_form').dialog('close');
//                }
//            });
            return false;
        });
    });
</script>