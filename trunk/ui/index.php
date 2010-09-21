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
        'status' => array(
            'name' => 'Status',
            'key' => 'status',
            'pages' => array(
                'system' => array(
                    'name' => 'System',
                    'key' => 'system',
                    'tabs' => array(
                        'system' => array(
                            'name' => 'System',
                            'key' => 'system'
                        )
                    )
                ),
                'ifaces' => array(
                    'name' => 'Interfaces',
                    'key' => 'ifaces',
                    'tabs' => array(
                        'wan' => array(
                            'name' => 'WAN',
                            'key' => 'wan'
                        ),
                        'lan' => array(
                            'name' => 'LAN',
                            'key' => 'lan'
                        )
                    )
                )
            )
        ),
        'system' => array(
            'name' => 'System',
            'key' => 'system',
            'pages' => array(
                'genset' => array(
                    'name' => 'General settings',
                    'key' => 'genset',
                    'tabs' => array(
                        'genset' => array(
                            'name' => 'General settings',
                            'key' => 'genset',
                        )
                    )
                ),
                'update' => array(
                    'name' => 'Firmware update',
                    'key' => 'update',
                    'tabs' => array(
                        'auto' => array(
                            'name' => 'Automatic',
                            'key' => 'auto',
                        ),
                        'manual' => array(
                            'name' => 'Manual',
                            'key' => 'manual',
                        )
                    )
                ),
                'reboot' => array(
                    'name' => 'Reboot',
                    'key' => 'reboot',
                    'tabs' => array(
                        'reboot' => array(
                            'name' => 'Reboot',
                            'key' => 'reboot',
                        )
                    )
                ),
                'backrest' => array(
                    'name' => 'Backup / restore',
                    'key' => 'backrest',
                    'tabs' => array(
                        'backrest' => array(
                            'name' => 'Backup / restore',
                            'key' => 'backrest',
                        )
                    )
                ),
            )
        ),
        'interfaces' => array(
            'name' => 'Interfaces',
            'key' => 'interfaces',
            'pages' => array(
                'wireless' => array(
                    'name' => 'Wireless',
                    'key' => 'wlan',
                    'tabs' => array(
                        'wlan' => array(
                            'name' => 'Wireless',
                            'key' => 'wlan',
                        )
                    )
                ),
                'lan' => array(
                    'name' => 'LAN',
                    'key' => 'lan',
                    'tabs' => array(
                        'lan' => array(
                            'name' => 'LAN',
                            'key' => 'lan',
                        )
                    )
                ),
                'wan' => array(
                    'name' => 'WAN',
                    'key' => 'wan',
                    'tabs' => array(
                        'wan' => array(
                            'name' => 'WAN',
                            'key' => 'wan',
                        )
                    )
                )
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
