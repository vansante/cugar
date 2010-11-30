<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_mode3"></a>Central server settings</h2>

<p class="intro">You can define the configuration server address here.</p>

<form id="advanced_captivep_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="advanced_captivep_form_error">
    </div>

    <input type="hidden" name="module" value="Mode3"/>
    <input type="hidden" name="page" value="save" id="advanced_captivep_form_page"/>
    
    <dl>
        <dt><label for="mode_mode3_server">Configuration server</label></dt>
        <dd>
            <input type="text" size="40" name="mode_mode3_server" id="mode_mode3_server"/>
        </dd>

        <dt><label for="mode_mode3_public_key">Public key</label></dt>
        <dd>
            <input name="mode_mode3_public_key" type="file" id="mode_mode3_public_key" />
        </dd>

        <dt><label for="mode_mode3_private_key">Private key</label></dt>
        <dd>
            <input name="mode_mode3_private_key" type="file" id="mode_mode3_private_key" />
        </dd>

        <dt><label for="mode_mode3_certificate">Certificate of Authority (CA)</label></dt>
        <dd>
            <input name="mode_mode3_certificate" type="file" id="mode_mode3_certificate" />
        </dd>

        <dt><input type="submit" value="Save" id="mode_mode3_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_mode_mode3_server">Please enter the URL or the IP address of the server that should configure your accesspoint</div>
    <div class="help" id="help_mode_mode3_public_key">Please upload your public key file (*.crt)</div>
    <div class="help" id="help_mode_mode3_private_key">Please upload your private key file (*.key)</div>
    <div class="help" id="help_mode_mode3_certificate">Please upload your certificate file (ca.crt)</div>
</div>

<script type="text/javascript">
cg.mode.mode3.loadForm = function() {
    var data = cg.data.mode3;
    cg.resetForm('mode_mode3_form');

    $('#mode_mode3_server').val(data.server);
};

$(function(){
    //Handler for submitting the form
    $('#mode_mode3_form').submit(function() {
       cg.doFormAction({
            url: 'test_xml/modes.xml',
            form_id: 'mode_mode3',
            error_element: $('#mode_mode3_form_error'),
            successFn: function(json) {
                cg.data.mode3 = json.modes.mode3;

                cg.mode.mode3.loadForm();
            }
        });
        return false;
    });
});
</script>