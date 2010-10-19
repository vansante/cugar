<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_mode2_website"></a>Captive portal settings</h2>

<p class="intro">You can define the settings for the captive portal here.</p>

<h3>Website whitelist</h3>

<div class="form-error" id="mode_mode2_website_table_error">
</div>

<table id="mode_mode2_website_table">
    <thead>
        <tr>
            <th>Website</th>
            <th width="16">&nbsp;</th>
            <th width="16">&nbsp;</th>
        </tr>
    </thead>
    <tbody id="mode_mode2_website_tbody">

    </tbody>
</table>

<p>
    <a class="button" href="#advanced_captivep" id="mode_mode2_website_add_link">Add new website</a>
</p>

<form id="mode_mode2_website_form" action="ajaxserver.php" method="post" class="dialog" title="Add new website">
    <div class="form-error" id="mode_mode2_website_form_error">
    </div>

    <input type="hidden" name="module" value="CaptivePortal"/>
    <input type="hidden" name="page" value="add_website" id="mode_mode2_website_form_page"/>
    <input type="hidden" name="mode_mode2_website_id" value="" id="mode_mode2_website_id"/>

    <dl>
        <dt><label for="mode_mode2_website_website">Website</label></dt>
        <dd>
            <input type="text" name="mode_mode2_website_website" id="mode_mode2_website_website"/>
        </dd>
        
        <dt><input type="submit" value="Add website" id="mode_mode2_website_submit" class="submitbutton"/></dt>
    </dl>
</form>


<div class="help_pool">
    
</div>

<script type="text/javascript">
    //Build the rules table
    cg.mode.mode2.whitelist = {};
    cg.mode.mode2.whitelist.buildTable = function() {

    };

    //Add a rule to the table
    cg.mode.mode2.whitelist.addRule = function(rule) {
        
    };

    cg.mode.mode2.whitelist.resetForm = function() {
        cg.resetForm('mode_mode2_website_form');
    };

    //Load a rule into firewall rules form
    cg.mode.mode2.whitelist.formLoadRule = function(rule) {
        
    };

    $(function() {
        $('#mode_mode2_website_form').dialog({
            autoOpen: false,
            resizable: false,
            width: 400,
            minHeight: 100,
            modal: true
        });

        //Click handler for adding
        $('#mode_mode2_website_add_link').click(function() {
            cg.mode.mode2.whitelist.resetForm();
            $('#mode_mode2_website_form_page').val('add_website');
            $('#mode_mode2_website_id').val(false);
            $('#mode_mode2_website_submit').val('Add website');
            $('#mode_mode2_website_form').dialog('option', 'title', 'Add new website');
            $('#mode_mode2_website_form').dialog('open');
            return false;
        });

        //Click handler(s) for editing
        //Live handler because edit button doesn't exist on document.ready
        $('.edit_mode2_website').live('click', function() {
            var rule = cg.data.proxy_ports[$(this).attr('rel')];
            cg.mode.mode2.whitelist.formLoadRule(rule);
            $('#mode_mode2_website_form').dialog('open');
            return false;
        });

        //Click handler for deleting rule
        $('.delete_mode2_website').live('click', function() {
            var id = $(this).attr('rel');
            cg.confirm("Are you sure?", "Are you sure you want to delete this website?", function() {
//                cg.doAction({
//                    url: 'testxml/reply.xml',
//                    module: 'Proxy',
//                    page: 'deleteport',
//                    params: {
//                        portid: id
//                    },
//                    error_element: $('#mode_mode2_website_table_error'),
//                    content_id: 'cp_mode_mode2_websites',
//                    successFn: function(json) {
//                        delete cg.data.proxy_ports[id];
//                        cg.mode.mode2.whitelist.buildTable();
//                    }
//                });
            });
            return false;
        });

        //Handler for submitting the form
        $('#mode_mode2_website_form').submit(function() {
//            cg.doFormAction({
//                url: 'testxml/',
//                form_id: 'mode_mode2_website_form',
//                error_element: $('#mode_mode2_website_form_error'),
//                successFn: function(json) {
//                    cg.data.proxy_ports[json.proxy.ports.port.id] = json.proxy.ports.port;
//                    cg.mode.mode2.whitelist.buildTable();
//                    $('#mode_mode2_website_form').dialog('close');
//                }
//            });
            return false;
        });
    });
</script>