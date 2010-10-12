<?php
/**
 * @author Paul van Santen
 */

/*
 * Debug setting, when set to true the login session var will be set automaticly
 * and the AJAX requests will go to dummy data located in the testxml folder.
 * Needs to be set to false before deploying to the appliance.
 */
$debug = true;

session_start();

require_once('json_encode.php');

require_once('Savant3.php');
$tpl = new Savant3();
$tpl->setPath('template', 'templates');
//$tpl->addFilters(array('Savant3_Filter_trimwhitespace', 'filter'));

// Login tonen
if (empty($_SESSION['uid'])) {
    $tpl->display('login.tpl.php');

    if ($debug) {
        $_SESSION['uid'] = 1;
        $_SESSION['group'] = 'ROOT';
    }
} else {
    $menu = array(
        array(
            'name' => 'Status',
            'key' => 'status',
            'tabs' => array(
                array(
                    'name' => 'System',
                    'key' => 'system'
                )
            )
        ),
        array(
            'name' => 'Basic settings',
            'key' => 'basic',
            'tabs' => array(
                array(
                    'name' => 'Basic settings',
                    'key' => 'settings'
                )
            )
        ),
        array(
            'name' => 'Mode settings',
            'key' => 'mode',
            'tabs' => array(
                array(
                    'name' => 'Mode selection',
                    'key' => 'selection'
                ),
                array(
                    'name' => 'Wireless',
                    'key' => 'mode1'
                ),
                array(
                    'name' => 'Captive portal',
                    'key' => 'mode2'
                ),
                array(
                    'name' => 'Central server',
                    'key' => 'mode3'
                )
            )
        ),
        array(
            'name' => 'Firmware update',
            'key' => 'update',
            'tabs' => array(
                array(
                    'name' => 'Manual',
                    'key' => 'manual'
                )
            )
        )
    );
    
    //Build the javascript namespace based on menu structure
    $data = array();
    foreach ($menu as $page) {
        $data[$page['key']] = array();
        foreach ($page['tabs'] as $tab) {
            $data[$page['key']][$tab['key']] = array();
        }
    }
    //Space for xml objects
    $data['data'] = array();
    $tpl->pages = $menu;
    $tpl->namespace = json_encode_custom($data, true);
    $tpl->debug = $debug;

    $tpl->display('layout.tpl.php');
}
