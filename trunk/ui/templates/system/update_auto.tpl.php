<h2>Automatic firmware update</h2>

<p class="intro">If there is a firmware update it will be shown here. You can check for updates by pressing the check button. If there is one you can then view the changelog and decide whether to update or not.</p>

<div class="form-error" id="system_update_auto_error">
</div>

<p>
    <a class="button" id="system_update_auto_check_link" href="#system_update">Check for updates</a>
</p>

<div class="note" id="system_update_auto_no_update">
    <h3>Note</h3>
    <p>There are no new releases.</p>
</div>

<div class="warning" id="system_update_auto_warning">
    <h3>Warning:</h3>
    <p>Do NOT abort the firmware update once it has started. The appliance will reboot automatically after storing the new firmware. The configuration will be maintained.</p>
</div>

<form id="system_update_auto_form" action="ajaxserver.php" method="post">
    <input type="hidden" name="module" value="Update"/>
    <input type="hidden" name="page" value="updatefirmware" id="system_update_auto_form_page"/>

    <div class="form-error" id="system_update_auto_form_error">
    </div>

    <dl>
        <dt>New version</dt>
        <dd>
            <span id="system_update_auto_version"></span>
        </dd>

        <dt>Issue date</dt>
        <dd>
            <span id="system_update_auto_date"></span>
        </dd>

        <dt>Filename</dt>
        <dd>
            <span id="system_update_auto_filename"></span>
        </dd>
    </dl>
    
    <p style="clear: both;"></p>

    <h3>Changelog</h3>
    <div class="release-changelog" id="system_update_auto_changelog"></div>

    <dl>
        <dt><input type="submit" value="Update firmware" id="system_update_auto_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>

<script type="text/javascript">
    cg.system.update.auto.checkUpdates = function(auto_check) {
        cg.system.update.auto.resetForm();
        cg.doAction({
            url: 'testxml/update.xml',
            module: 'Update',
            page: 'check',
            error_element: $('#system_update_auto_error'),
            content_id: 'cp_system_update_auto',
            successFn: function(json) {
                if (json.release) {
                    cg.data.new_release = json.release;
                    
                    if (auto_check && self.document.location.hash != '#system_update') {
                        var txt = '<p>There is a new firmware with version <strong>'
                            +json.release.version+'</strong> issued on <strong>'+json.release.date+'</strong>.'
                            +'<br>Do you want to go to the firmware update page to apply it?</p>';

                        cg.confirm('New firmware', txt, function() {
                            cg.update_alert_given = true;
                            // Go to the firmware update page
                            $('.module').hide();
                            $('.page').hide();
                            $('a.active').removeClass('active');
                            $('#cp_system_update').show().parent().show();
                            $('#system_update').addClass('active');
                            $('#menu').accordion('activate' , '#system');
                        });
                    }
                }
                cg.system.update.auto.loadForm();
            }
        });
    };

    cg.system.update.auto.resetForm = function() {
        $('#system_update_auto_warning, #system_update_auto_form, #system_update_auto_no_update').hide();
    };

    cg.system.update.auto.loadForm = function() {
        if (cg.data.new_release) {
            var rls = cg.data.new_release;
            $('#system_update_auto_version').html(rls.version);
            $('#system_update_auto_date').html(rls.date);
            $('#system_update_auto_filename').html(rls.filename);
            $('#system_update_auto_changelog').html('<pre>'+rls.changelog+'</pre>');

            $('#system_update_auto_warning, #system_update_auto_form').slideDown(500);
        } else {
            $('#system_update_auto_no_update').slideDown(500);
        }
    };

    $(function() {
        $('#system_update_auto_form').submit(function(){
            cg.confirm("Are you sure?", "Are you sure you want to update the devices firmware?", function() {
                cg.doFormAction({
                    url: 'testxml/reply.xml',
                    form_id: 'system_update_auto_form',
                    error_element: $('#system_update_auto_form_error'),
                    successFn: function(json) {
                        cg.rebootNotice(90);
                    }
                });
            });
            return false;
        });

        $('#system_update_auto_check_link').click(function() {
            cg.system.update.auto.checkUpdates(false);
            return false;
        });
    });
</script>