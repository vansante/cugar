<h2>Manual firmware update</h2>

<p class="intro">Choose the image file (net48xx-*.img) to be uploaded. Click "Upload" to start the update process.</p>

<div class="warning">
    <h3>Warning:</h3>
    <p>Do NOT abort the firmware update once it has started. The appliance will reboot automatically after storing the new firmware. The configuration will be maintained.</p>
</div>

<form id="system_update_manual_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="system_update_manual_form_error">
    </div>

    <input type="hidden" name="module" value="Update"/>
    <input type="hidden" name="page" value="updatefirmwaremanual" id="system_update_manual_form_page"/>
    
    <dl>
        <dt><label for="system_update_manual_image">Firmware image</label></dt>
        <dd>
            <input name="system_update_manual_image" type="file" id="system_update_manual_image"/>
        </dd>

        <dt><input type="submit" value="Update firmware" id="system_update_manual_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<script type="text/javascript">
    $(function() {
        $('#system_update_manual_form').submit(function(){
            cg.confirm("Are you sure?", "Are you sure you want to update the devices firmware?", function() {
                cg.doFormAction({
                    url: 'testxml/reply.xml',
                    form_id: 'system_update_manual_form',
                    error_element: $('#system_update_manual_form_error'),
                    successFn: function(json) {
                        cg.rebootNotice();
                    }
                });
            });
            return false;
        });
    });
</script>