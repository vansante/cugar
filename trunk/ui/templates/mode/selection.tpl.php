<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_selection"></a>Device mode selection</h2>

<p class="intro">You can select the device mode here.</p>

<form id="mode_selection_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="mode_selection_form_error">
    </div>

    <input type="hidden" name="module" value="Mode"/>
    <input type="hidden" name="page" value="saveselection" id="mode_selection_form_page"/>

    <dl>
        <dt><label for="mode_selection_mode">Device mode</label></dt>
        <dd>
            <input name="mode_selection_mode" type="radio" id="mode_selection_mode_1" value="1"/>
            <label for="mode_selection_mode_1">Basic accesspoint</label>
            <br/>
            <input name="mode_selection_mode" type="radio" id="mode_selection_mode_2" value="2"/>
            <label for="mode_selection_mode_2">Accesspoint with captive portal</label>
            <br/>
            <input name="mode_selection_mode" type="radio" id="mode_selection_mode_3" value="3"/>
            <label for="mode_selection_mode_3">Central server configuration</label>
            <br/>
            <input name="mode_selection_mode" type="radio" id="mode_selection_mode_1_2" value="1_2"/>
            <label for="mode_selection_mode_1_2">Basic accesspoint and a secondary with captive portal</label>
            <br/>
            <input name="mode_selection_mode" type="radio" id="mode_selection_mode_1_3" value="1_3"/>
            <label for="mode_selection_mode_1_3">Basic accesspoint and a secondary with central server configuration</label>
        </dd>

        <dt><input type="submit" value="Save" id="mode_selection_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>

<script type="text/javascript">
$(function() {
    $('#tabs_mode').tabs('option', 'disabled', [1, 2, 3]);

    $('#mode_selection_form input[name=mode_selection_mode]').click(function() {
        switch(this.value) {
            case '1':
                $('#tabs_mode').tabs('option', 'disabled', [2, 3]);
                break
            case '2':
                $('#tabs_mode').tabs('option', 'disabled', [1, 3]);
                break;
            case '3':
                $('#tabs_mode').tabs('option', 'disabled', [1, 2]);
                break;
            case '1_2':
                $('#tabs_mode').tabs('option', 'disabled', [3]);
                break;
            case '1_3':
                $('#tabs_mode').tabs('option', 'disabled', [2]);
                break;
        }
    });
});

cg.mode.selection.loadForm = function() {
    var data = cg.data.mode_selection;
    cg.resetForm('mode_selection_form');

    $('#mode_selection_mode_'+data.mode_selection).attr('checked', 'checked');
    switch(data.mode_selection) {
        case '1':
            $('#tabs_mode').tabs('option', 'disabled', [2, 3]);
            break
        case '2':
            $('#tabs_mode').tabs('option', 'disabled', [1, 3]);
            break;
        case '3':
            $('#tabs_mode').tabs('option', 'disabled', [1, 2]);
            break;
        case '1_2':
            $('#tabs_mode').tabs('option', 'disabled', [3]);
            break;
        case '1_3':
            $('#tabs_mode').tabs('option', 'disabled', [2]);
            break;
    }
};

$(function(){
    //Handler for submitting the form
    $('#mode_selection_form').submit(function() {
        cg.doFormAction({
            url: 'test_xml/modes.xml',
            form_id: 'basic_settings_form',
            error_element: $('#basic_settings_form_error'),
            successFn: function(json) {
                cg.data.mode_selection = json.modes;
                cg.data.mode1 = json.modes.mode1;
                cg.data.mode2 = json.modes.mode2;
                cg.data.mode3 = json.modes.mode3;

                cg.mode.loadAllForms();
            }
        });
        return false;
    });
});
</script>