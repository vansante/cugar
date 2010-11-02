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

        <dt><label for="mode_mode1_channel">Channel</label></dt>
        <dd>
            <select name="mode_mode1_channel" id="mode_mode1_channel">
                <option value="auto">Auto</option>
                <?php for ($i = 0; $i < 14; $i++) : ?>
                <option value="<?=$i?>"><?=$i?></option>
                <?php endfor ?>
            </select>
        </dd>

        <dt><label for="mode_mode1_mode">Wireless mode</label></dt>
        <dd>
            <select name="mode_mode1_mode" id="mode_mode1_mode">
                <option value="b_g_n">Wireless B/G/N</option>
                <option value="b">Wireless B</option>
                <option value="g">Wireless G</option>
                <option value="n">Wireless N</option>
            </select>
        </dd>

        <dt><label for="mode_mode1_encryption">Wireless encryption</label></dt>
        <dd>
            <select name="mode_mode1_encryption" id="mode_mode1_encryption">
                <option value="wpa">WPA</option>
                <option value="wpa2">WPA2</option>
                <option value="none">None</option>
            </select>
        </dd>

        <dt><label for="mode_mode1_pass">Passphrase</label></dt>
        <dd>
            <input name="mode_mode1_pass" type="text" id="mode_mode1_pass" />
        </dd>

        <dt><input type="submit" value="Save" id="mode_mode1_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>