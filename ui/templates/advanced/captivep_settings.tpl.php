<h2 class="help_anchor"><a class="open_all_help" rel="cp_advanced_captivep_settings"></a>Basic settings</h2>

<form id="advanced_captivep_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="advanced_captivep_form_error">
    </div>

    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="savegeneralsettings" id="advanced_captivep_form_page"/>
    
    <dl>
        <dt><label for="advanced_captivep_settingserver">Settings server</label></dt>
        <dd>
            <input type="text" size="40" name="advanced_captivep_settingserver" id="advanced_captivep_settingserver"/>
        </dd>

        <dt><label for="advanced_captivep_publickey">Public key</label></dt>
        <dd>
            <input name="advanced_captivep_publickey" type="file" id="advanced_captivep_publickey" />
        </dd>

        <dt><label for="advanced_captivep_privatekey">Private key</label></dt>
        <dd>
            <input name="advanced_captivep_privatekey" type="file" id="advanced_captivep_privatekey" />
        </dd>

        <dt><input type="submit" value="Save" id="advanced_captivep_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    
</div>