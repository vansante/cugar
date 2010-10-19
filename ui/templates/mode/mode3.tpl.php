<h2 class="help_anchor"><a class="open_all_help" rel="cp_mode_mode3"></a>Central server settings</h2>

<p class="intro">You can define the central server address here.</p>

<form id="advanced_captivep_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="advanced_captivep_form_error">
    </div>

    <input type="hidden" name="module" value="System"/>
    <input type="hidden" name="page" value="savegeneralsettings" id="advanced_captivep_form_page"/>
    
    <dl>
        <dt><label for="mode_mode3_server">Settings server</label></dt>
        <dd>
            <input type="text" size="40" name="mode_mode3_server" id="mode_mode3_server"/>
        </dd>

        <dt><label for="mode_mode3_publickey">Public key</label></dt>
        <dd>
            <input name="mode_mode3_publickey" type="file" id="mode_mode3_publickey" />
        </dd>

        <dt><label for="mode_mode3_privatekey">Private key</label></dt>
        <dd>
            <input name="mode_mode3_privatekey" type="file" id="mode_mode3_privatekey" />
        </dd>

        <dt><input type="submit" value="Save" id="mode_mode3_submit" class="submitbutton"/></dt>
    </dl>
    
    <p style="clear: both;"></p>
</form>

<div class="help_pool">
    
</div>