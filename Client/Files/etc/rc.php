#!/usr/local/bin/php
<?php 

include_once('/usr/local/lib/CUGAR/bootstrap/bootstrap.php');
require_once('/usr/local/lib/CUGAR/comm/Comm.php');
require_once('/usr/local/lib/CUGAR/comm/FetchConfig.php');
require_once('/usr/local/lib/CUGAR/lib/Functions.php');
require_once('/usr/local/lib/CUGAR/bootstrap/Networking.php');
require_once('/usr/local/lib/CUGAR/bootstrap/OpenVPN.php');
error_reporting(E_ALL);
$strap = new BootStrap(Bootstrap::$RUNMODE_DEBUG);

require_once('/usr/local/lib/CUGAR/parser/Parser.php');
require_once('/usr/local/lib/CUGAR/parser/Statement.php');
require_once('/usr/local/lib/CUGAR/parser/config.php');
require_once('/usr/local/lib/CUGAR/lib/ErrorStore.php');
require_once('/usr/local/lib/CUGAR/exceptions.php');
require_once('/usr/local/lib/CUGAR/config/ConfigGenerator.php');
require_once('/usr/local/lib/CUGAR/config/DHCPRelay.php');
require_once('/usr/local/lib/CUGAR/config/Hostap.php');
require_once('/usr/local/lib/CUGAR/config/OpenVPN.php');
require_once('/usr/local/lib/CUGAR/config/Portal.php');
require_once('/usr/local/lib/CUGAR/config/RC.php');
require_once('/usr/local/lib/CUGAR/config/System.php');

try{
    $xml = new XMLParser();
    $xml->setErrorLevel(2);
    $xml->loadXML('/etc/CUGAR/config.xml');
    $xml->parse();
}
catch(Exception $e){
    print_r($e->getMessage());
    $error = ErrorStore::getInstance();
    $error->addError($e);
    $error->printErrorsToFile(ErrorStore::$E_WARNING);
}
?>