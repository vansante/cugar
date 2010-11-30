<h2>Reboot</h2>

<p class="intro">Click reboot to reboot the system</p>

<form id="system_reboot_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="system_reboot_form_error">
    </div>


    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="reboot" id="system_reboot_form_page"/>

    <dl>
        <dt><input type="submit" value="Reboot" id="system_reboot_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>
