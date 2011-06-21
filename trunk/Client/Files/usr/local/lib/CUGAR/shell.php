<?php
/*
 All rights reserved.
 Copyright (C) 2010-2011 CUGAR
 All rights reserved.

 Redistribution and use in source and binary forms, with or without
 modification, are permitted provided that the following conditions are met:

 1. Redistributions of source code must retain the above copyright notice,
 this list of conditions and the following disclaimer.

 2. Redistributions in binary form must reproduce the above copyright
 notice, this list of conditions and the following disclaimer in the
 documentation and/or other materials provided with the distribution.

 THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 POSSIBILITY OF SUCH DAMAGE.
 */
include_once('/usr/local/lib/CUGAR/bootstrap/bootstrap.php');
require_once('/usr/local/lib/CUGAR/comm/Comm.php');
require_once('/usr/local/lib/CUGAR/comm/FetchConfig.php');
require_once('/usr/local/lib/CUGAR/lib/Functions.php');
require_once('/usr/local/lib/CUGAR/bootstrap/Networking.php');
require_once('/usr/local/lib/CUGAR/bootstrap/OpenVPN.php');
require_once('/usr/local/lib/CUGAR/bootstrap/Configuration.php');
require_once('/usr/local/lib/CUGAR/parser/Parser.php');
require_once('/usr/local/lib/CUGAR/parser/Statement.php');
require_once('/usr/local/lib/CUGAR/parser/config.php');
require_once('/usr/local/lib/CUGAR/lib/ErrorStore.php');
require_once('/usr/local/lib/CUGAR/exceptions.php');
require_once('/usr/local/lib/CUGAR/config/ConfigGenerator.php');
require_once('/usr/local/lib/CUGAR/config/Hostap.php');
require_once('/usr/local/lib/CUGAR/config/OpenVPN.php');
require_once('/usr/local/lib/CUGAR/config/Portal.php');
require_once('/usr/local/lib/CUGAR/config/RC.php');
require_once('/usr/local/lib/CUGAR/config/System.php');

/**
 * CUGAR shell extension for individual component debugging
 */
class CugarShell{
	public function __construct(){
		//	Arguments passed to script
		global $argv;
		/**
		 * TODO: build this in my spare time
		 */
		print_r($argv);
	}
}