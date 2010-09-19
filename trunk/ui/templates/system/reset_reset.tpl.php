<h2>Reset to factory defaults</h2>

<p class="intro">The reset screen allows you to reset the device to its factory defaults.</p>

<div class="warning">
    <h3>Warning:</h3>
    <!-- TODO: This info is incorrect! -->
    <p>If you reset the device, the firewall will be reset to factory defaults and will reboot immediately. The entire system configuration will be overwritten. The LAN IP address will be reset to 192.168.1.1, the system will be configured as a DHCP server, and the password will be set to 'password'.</p>
</div>

<form id="system_reset_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="system_reset_form_error">
    </div>

    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="reset" id="system_reset_form_page"/>

    <dl>
        <dt><input type="submit" value="Reset" id="system_reset_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>