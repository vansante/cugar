<h2 class="help_anchor"><a class="open_all_help" rel="cp_system_backrest_backrest"></a>Backup / restore</h2>

<p class="intro">This page allows you to restore a backup configuration XML file or make a backup of the current XML configuration file.</p>

<h3>Backup configuration</h3>

<form id="system_backrest_backup_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="system_backrest_backup_form_error">
    </div>
    
    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="getconfigxml" id="system_backrest_backup_form_page"/>

    <dl>
        <dt><label for="system_backrest_backup_submit">Backup</label></dt>
        <dd>
            <input type="submit" value="Download configuration" id="system_backrest_backup_submit" class="submitbutton"/>
        </dd>
    </dl>

    <p style="clear: both;"></p>
</form>

<h3>Restore configuration</h3>

<form id="system_backrest_restore_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="system_backrest_restore_form_error">
    </div>

    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="saveconfigxml" id="system_backrest_restore_form_page"/>
    
    <dl>
        <dt><label for="system_backrest_restorexml">Restore</label></dt>
        <dd>
            <input type="file" name="system_backrest_restorexml" id="system_backrest_restorexml"/>
        </dd>
        
        <dt><input type="submit" value="Restore configuration" id="system_backrest_restore_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    <div class="help" id="help_system_backrest_backup_submit">Click this button to save the system configuration in XML format.</div>
    <div class="help" id="help_system_backrest_restorexml">Open a configuration XML file and click the button below to restore the configuration.</div>
</div>