<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_mode2"></a>Captive portal</h2>

<p class="intro">You can define the captive portal settings here.</p>

<form id="mode_mode2_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="mode_mode2_form_error">
    </div>

    <input type="hidden" name="module" value="Mode2"/>
    <input type="hidden" name="page" value="save" id="mode_mode2_form_page"/>

    <h3>Wireless settings</h3>
    
    <dl>
        <dt><label for="mode_mode2_ssid">SSID</label></dt>
        <dd>
            <input name="mode_mode2_ssid" type="text" id="mode_mode2_ssid" />
        </dd>

        <dt><label for="mode_mode2_encryption">Wireless encryption</label></dt>
        <dd>
            <select name="mode_mode2_encryption" id="mode_mode2_encryption">
                <option value="wpa">WPA</option>
                <option value="wpa2">WPA2</option>
                <option value="none">None</option>
            </select>
        </dd>

        <dt><label for="mode_mode2_passphrase">Passphrase</label></dt>
        <dd>
            <input name="mode_mode2_passphrase" type="text" id="mode_mode2_passphrase" />
        </dd>
    </dl>

    <p style="clear: both;"></p>

    <h3>Captive portal settings</h3>

    <dl>
        <dt>Portal page mode</dt>
        <dd>
            <input name="mode_mode2_portalmode" type="radio" id="mode_mode2_portalmode_url" value="url"/>
            <label for="mode_mode2_portalmode_url">URL on external server</label>
            <br/>
            <input name="mode_mode2_portalmode" type="radio" id="mode_mode2_portalmode_local" value="local"/>
            <label for="mode_mode2_portalmode_local">HTML on local device</label>
        </dd>

        <dt class="mode_mode2_url"><label for="mode_mode2_url">Portal url</label></dt>
        <dd class="mode_mode2_url">
            <input name="mode_mode2_url" type="text" size="40" id="mode_mode2_url" />
        </dd>

        <dt class="mode_mode2_local"><label for="mode_mode2_localfile">HTML page(s) (in ZIP file)</label></dt>
        <dd class="mode_mode2_local">
            <input name="mode_mode2_localfile" type="file" id="mode_mode2_localfile" />
        </dd>

        <dt><input type="submit" value="Save" id="mode_mode2_submit" class="submitbutton"/></dt>
    </dl>

</form>

<p style="clear: both;"></p>

<h3>Whitelist</h3>

<div class="form-error" id="mode_mode2_whitelist_table_error">
</div>

<table id="mode_mode2_whitelist_table">
    <thead>
        <tr>
            <th>Item</th>
            <th width="16">&nbsp;</th>
            <th width="16">&nbsp;</th>
        </tr>
    </thead>
    <tbody id="mode_mode2_whitelist_tbody">

    </tbody>
</table>

<p>
    <a class="button" href="#" id="mode_mode2_whitelist_add_link">Add new whitelist item</a>
</p>

<form id="mode_mode2_whitelist_form" action="ajaxserver.php" method="post" class="dialog" title="Add new whitelist item">
    <div class="form-error" id="mode_mode2_whitelist_form_error">
    </div>

    <input type="hidden" name="module" value="Mode2"/>
    <input type="hidden" name="page" value="add_whitelist_item" id="mode_mode2_whitelist_form_page"/>
    <input type="hidden" name="mode_mode2_whitelist_id" value="" id="mode_mode2_whitelist_id"/>

    <dl>
        <dt><label for="mode_mode2_whitelist_item">Item (IP/subnet/URL)</label></dt>
        <dd>
            <input type="text" name="mode_mode2_whitelist_item" size="40" id="mode_mode2_whitelist_item"/>
        </dd>

        <dt><input type="submit" value="Add item" id="mode_mode2_whitelist_submit" class="submitbutton"/></dt>
    </dl>
</form>

<div class="help_pool">
    <div class="help" id="help_mode_mode2_ssid">Please enter the SSID that the accesspoint should broadcast</div>
    <div class="help" id="help_mode_mode2_encryption">Please select which encryption type the accesspoint should use</div>
    <div class="help" id="help_mode_mode2_passphrase">Please enter the passphrase used for authentication with the accesspoint</div>
    <div class="help" id="help_mode_mode2_portal_url">Please enter url that should be used as your homepage upon connecting with the accesspoint</div>
    <div class="help" id="help_mode_mode2_portal_localfile">Please supply a zipfile with all the files necessary for your homepage</div>
    <div class="help" id="help_mode_mode2_whitelist_item">Please enter a whitelist item in the form of an URL (google.com), an IP address (xxx.xxx.xxx.xxx) or a subnet (xxx.xxx.xxx.xxx/xx)</div>
</div>
<script type="text/javascript">
$(function() {
    $('#mode_mode2_form input[name=mode_mode2_portalmode]').click(function() {
        if (this.value.toLowerCase() == 'url') {
            $('.mode_mode2_url').slideDown();
            $('.mode_mode2_url input').removeAttr('disabled');
            $('.mode_mode2_local').hide();
            $('.mode_mode2_local input').attr('disabled', 'disabled');
        } else {
            $('.mode_mode2_local').slideDown();
            $('.mode_mode2_local input').removeAttr('disabled');
            $('.mode_mode2_url').hide();
            $('.mode_mode2_url input').attr('disabled', 'disabled');
        }
    });
});

cg.mode.mode2.loadForm = function() {
    var data = cg.data.mode2;
    cg.resetForm('mode_mode2_form');

    $('#mode_mode2_ssid').val(data.ssid_name);
    $('#mode_mode2_encryption').val(data.wpa.mode);
    $('#mode_mode2_passphrase').val(data.wpa.passphrase);
    
    if (data.portal.mode == 'url') {
        $('#mode_mode2_portalmode_url').attr('checked', 'checked');

        $('.mode_mode2_url').slideDown();
        $('.mode_mode2_url input').removeAttr('disabled');
        $('.mode_mode2_local').hide();
        $('.mode_mode2_local input').attr('disabled', 'disabled');
        
        $('#mode_mode2_url').val(data.portal.url);
    } else {
        $('#mode_mode2_portalmode_local').attr('checked', 'checked');
        
        $('.mode_mode2_local').slideDown();
        $('.mode_mode2_local input').removeAttr('disabled');
        $('.mode_mode2_url').hide();
        $('.mode_mode2_url input').attr('disabled', 'disabled');
    }
};

cg.mode.mode2.whitelist = {};

//Load the whitelist table
cg.mode.mode2.whitelist.loadTable = function() {
    //Clear the current table data to (re)load it
    $('#mode_mode2_whitelist_tbody').empty();
    $.each(cg.data.mode2_whitelist, function(i, item) {
        cg.mode.mode2.whitelist.addItem(item);
    });
};

//Add an item to the table
cg.mode.mode2.whitelist.addItem = function(item) {
    var tblstring = '<tr>'+
        '<td>'+item+'</td>'+
        '<td><a href="#" rel="'+item+'" class="edit_mode2_whitelist_item" title="Edit whitelist item"><img src="images/icons/edit.png" alt="Edit item"/></a></td>'+
        '<td><a href="#" rel="'+item+'" class="delete_mode2_whitelist_item" title="Delete whitelist item"><img src="images/icons/delete.png" alt="Delete item"/></a></td>'+
        '</tr>';
    $('#mode_mode2_whitelist_tbody').append(tblstring);
};

//Load a rule into firewall rules form
cg.mode.mode2.whitelist.formLoadItem = function(item) {
    cg.resetForm('mode_mode2_whitelist_form');

    $('#mode_mode2_whitelist_page').val('edit_whitelist_item');
    $('#mode_mode2_whitelist_id').val(item);
    $('#mode_mode2_whitelist_submit').val('Edit whitelist item');
    $('#mode_mode2_whitelist_form').dialog('option', 'title', 'Edit whitelist item');

    $('#mode_mode2_whitelist_item').val(item);
};

$(function() {
    $('#mode_mode2_whitelist_form').dialog({
        autoOpen: false,
        resizable: false,
        width: 600,
        minHeight: 100,
        modal: true
    });

    //Click handler for adding
    $('#mode_mode2_whitelist_add_link').click(function() {
        cg.resetForm('mode_mode2_whitelist_form');
        
        $('#mode_mode2_whitelist_form_page').val('add_whitelist_item');
        $('#mode_mode2_whitelist_id').val();
        $('#mode_mode2_whitelist_submit').val('Add whitelist item');
        $('#mode_mode2_whitelist_form').dialog('option', 'title', 'Add new whitelist item');
        $('#mode_mode2_whitelist_form').dialog('open');
        return false;
    });

    //Click handler(s) for editing
    //Live handler because edit button doesn't exist on document.ready
    $('.edit_mode2_whitelist_item').live('click', function() {
        var item = cg.data.mode2_whitelist[$(this).attr('rel')];
        cg.mode.mode2.whitelist.formLoadItem(item);
        $('#mode_mode2_whitelist_form').dialog('open');
        return false;
    });

    //Click handler for deleting rule
    $('.delete_mode2_whitelist_item').live('click', function() {
        var item = $(this).attr('rel');
        cg.confirm("Are you sure?", "Are you sure you want to delete this whitelist item?", function() {
            cg.doAction({
                url: 'test_xml/reply_ok.xml',
                module: 'Mode2',
                page: 'whitelist_delete_item',
                params: {
                    item: item
                },
                error_element: $('#mode_mode2_whitelist_table_error'),
                content_id: 'cp_mode_mode2_whitelist',
                successFn: function(json) {
                    delete cg.data.mode2_whitelist[item];
                    cg.mode.mode2.whitelist.loadTable();
                }
            });
        });
        return false;
    });

    //Handler for submitting the form
    $('#mode_mode2_whitelist_form').submit(function() {
        cg.doFormAction({
            url: 'test_xml/reply_ok.xml',
            form_id: 'mode_mode2_whitelist_form',
            error_element: $('#mode_mode2_whitelist_form_error'),
            successFn: function(json) {
                var item = $('#mode_mode2_whitelist_item').val();
                var id = $('#mode_mode2_whitelist_id').val();

                if (id.length) {
                    delete cg.data.mode2_whitelist[id];
                }
                cg.data.mode2_whitelist[item] = item;
                
                cg.mode.mode2.whitelist.loadTable();
                $('#mode_mode2_whitelist_form').dialog('close');
            }
        });
        return false;
    });
});
</script>