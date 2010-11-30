<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_mode1_wlan"></a>Wireless settings</h2>

<p class="intro">You can define the basic wireless settings here.</p>

<form id="mode_mode1_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="mode_mode1_form_error">
    </div>

    <input type="hidden" name="module" value="Mode1"/>
    <input type="hidden" name="page" value="save" id="mode_mode1_form_page"/>

    <dl>
        <dt><label for="mode_mode1_ssid">SSID</label></dt>
        <dd>
            <input name="mode_mode1_ssid" type="text" id="mode_mode1_ssid" />
        </dd>

        <dt><label for="mode_mode1_encryption">Wireless encryption</label></dt>
        <dd>
            <select name="mode_mode1_encryption" id="mode_mode1_encryption">
                <option value="wpa">WPA</option>
                <option value="wpa2">WPA2</option>
                <option value="none">None</option>
            </select>
        </dd>

        <dt><label for="mode_mode1_passphrase">Passphrase</label></dt>
        <dd>
            <input name="mode_mode1_passphrase" type="text" id="mode_mode1_passphrase" />
        </dd>

        <dt><input type="submit" value="Save" id="mode_mode1_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>

<script type="text/javascript">
cg.mode.mode1.loadForm = function() {
    var data = cg.data.mode1;
    cg.resetForm('mode_mode1_form');

    $('#mode_mode1_ssid').val(data.ssid_name);
    $('#mode_mode1_mode').val(data.mode);
    $('#mode_mode1_channel').val(data.channel);
    $('#mode_mode1_encryption').val(data.wpa.mode);
    $('#mode_mode1_passphrase').val(data.wpa.passphrase);
};

$(function(){
    //Handler for submitting the form
    $('#mode_mode1_form').submit(function() {
       cg.doFormAction({
            url: 'test_xml/modes.xml',
            form_id: 'mode_mode1',
            error_element: $('#mode_mode1_form_error'),
            successFn: function(json) {
                cg.data.mode1 = json.modes.mode1;

                cg.mode.mode1.loadForm();
            }
        });
        return false;
    });
});
</script>