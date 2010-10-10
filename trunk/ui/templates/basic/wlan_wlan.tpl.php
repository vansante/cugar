<h2 class="help_anchor"><a class="open_all_help" rel="cp_interfaces_wlan_wlan"></a>Wireless</h2>

<p class="intro"></p>


<form id="interfaces_wlan_form" action="ajaxserver.php" method="post">
    <div class="form-error" id="interfaces_wwlan_form_error">
    </div>

    <input type="hidden" name="module" value="wlan"/>
    <input type="hidden" name="page" value="save" id="interfaces_wlan_form_page"/>

    <dl>
        <dt><label for="interfaces_wlan_ssid">SSID</label></dt>
        <dd>
            <input name="interfaces_wlan_ssid" type="text" id="interfaces_wlan_ssid" />
        </dd>

        <dt><label for="interfaces_wlan_channel">Interface</label></dt>
        <dd>
            <select name="interfaces_wlan_channel" id="interfaces_wlan_channel">
                <option value="auto">Auto</option>
                <?php for ($i = 0; $i < 14; $i++) : ?>
                <option value="<?=$i?>"><?=$i?></option>
                <?php endfor ?>
            </select>
        </dd>

        <dt><label for="interfaces_wlan_mode">Wireless mode</label></dt>
        <dd>
            <select name="interfaces_wlan_mode" id="interfaces_wlan_mode">
                <option value="b_g_n">Wireless B/G/N</option>
                <option value="b">Wireless B</option>
                <option value="g">Wireless G</option>
                <option value="n">Wireless N</option>
            </select>
        </dd>

        <dt><label for="interfaces_wlan_encryption">Wireless encryption</label></dt>
        <dd>
            <select name="interfaces_wlan_encryption" id="interfaces_wlan_encryption">
                <option value="wpa">WPA</option>
                <option value="wpa2">WPA2</option>
                <option value="none">None</option>
            </select>
        </dd>

        <dt><label for="interfaces_wlan_pskey">Passphrase</label></dt>
        <dd>
            <input name="interfaces_wlan_pskey" type="text" id="interfaces_wlan_pskey" />
        </dd>

        <dt><input type="submit" value="Save" id="interfaces_wlan_submit" class="submitbutton"/></dt>
    </dl>

    <p style="clear: both;"></p>
</form>