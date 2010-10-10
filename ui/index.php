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
    $menu = array (
        array(
            'name' => 'Status',
            'key' => 'status',
            'pages' => array(
                array(
                    'name' => 'System',
                    'key' => 'system',
                    'tabs' => array(
                        array(
                            'name' => 'System',
                            'key' => 'system'
                        )
                    )
                ),
                array(
                    'name' => 'Interfaces',
                    'key' => 'ifaces',
                    'tabs' => array(
                        array(
                            'name' => 'WAN',
                            'key' => 'wan'
                        ),
                        array(
                            'name' => 'LAN',
                            'key' => 'lan'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Basic',
            'key' => 'basic',
            'pages' => array(
                array(
                    'name' => 'Settings',
                    'key' => 'settings',
                    'tabs' => array(
                        array(
                            'name' => 'Settings',
                            'key' => 'settings'
                        )
                    )
                ),
                array(
                    'name' => 'Wireless',
                    'key' => 'wlan',
                    'tabs' => array(
                        'wlan' => array(
                            'name' => 'Wireless',
                            'key' => 'wlan',
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'System',
            'key' => 'system',
            'pages' => array(
                array(
                    'name' => 'Firmware update',
                    'key' => 'update',
                    'tabs' => array(
                        array(
                            'name' => 'Automatic',
                            'key' => 'auto',
                        ),
                        array(
                            'name' => 'Manual',
                            'key' => 'manual',
                        )
                    )
                ),
                array(
                    'name' => 'Reboot',
                    'key' => 'reboot',
                    'tabs' => array(
                        array(
                            'name' => 'Reboot',
                            'key' => 'reboot',
                        )
                    )
                ),
                array(
                    'name' => 'Backup / restore',
                    'key' => 'backrest',
                    'tabs' => array(
                        array(
                            'name' => 'Backup / restore',
                            'key' => 'backrest',
                        )
                    )
                ),
            )
        )
    );
    
    //Build the javascript namespace based on menu structure
    $data = array();
    foreach ($menu as $mod) {
        $data[$mod['key']] = array();
        foreach ($mod['pages'] as $page) {
            $data[$mod['key']][$page['key']] = array();
            foreach ($page['tabs'] as $tab) {
                $data[$mod['key']][$page['key']][$tab['key']] = array();
            }
        }
    }
    //Space for xml objects
    $data['data'] = array();
    $tpl->modules = $menu;
    $tpl->namespace = json_encode_custom($data, true);
    $tpl->debug = $debug;

    $tpl->display('layout.tpl.php');
}
