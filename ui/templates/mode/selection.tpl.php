<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_selection"></a>Device mode selection</h2>

<p class="intro">You can select the device mode here.</p>

<form id="mode_selection_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="mode_selection_form_error">
    </div>

    <input type="hidden" name="module" value="ModeSelection"/>
    <input type="hidden" name="page" value="save" id="mode_selection_form_page"/>

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
        switch(this.value.toLowerCase()) {
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

    var type = $('#mode_selection_form input[name=mode_selection_mode]:checked').val();
    switch(type) {
        case '1':
            $('#tabs_mode').tabs('option', 'disabled', [2, 3]);
            break
        case '2':
            $('#tabs_mode').tabs('option', 'disabled', [1, 3]);
            break;
        case '3':
            $('#tabs_mode').tabs('option', 'disabled', [1, 2]);
            break;
    }
});
</script>