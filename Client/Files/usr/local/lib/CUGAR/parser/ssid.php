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

/**
 * 	Validate / interpret SSID statement
 *
 */
class ssid extends Statement {

    /**
     * Constructor
     *
     * @param Array $parse_opt
     * @return void
     */
    public function __construct($parse_opt) {
        $this->parse_options = $parse_opt;
        $this->expectedtags = Array('hostapd', 'openvpn', 'portal','traffic_mode');
    }

    /**
     * (non-PHPdoc)
     * @see Files/usr/local/lib/CUGAR/parser/Statement#interpret()
     */
    public function interpret($options) {
        $this->validate($options);

        //	Set mode for this SSID, child tags could need this for parsing.
        $this->parse_options['mode'] = (string) $options['mode'];
        $ref = HostAPDConfig::getInstance();
        $ref->newSSID();
        $ref->setSsidMode((string) $options['mode']);
        
        if($options['mode'] == 2){
        	//	Start new hotspot configuration, since we're at a mode2 SSID
        	$hp = PortalConfig::getInstance();
        	$hp->newPortal();
        }

        $this->parseChildren($options);
        
        if($options['mode'] == 2){
        	$hp->finishPortal();
        }
        
        $ref->finishSSID();
    }

    /**
     * (non-PHPdoc)
     * @see Files/usr/local/lib/CUGAR/parser/Statement#validate()
     */
    public function validate($options) {
        $errorstore = ErrorStore::getInstance();
        if ($options['mode'] >= 1 && $options['mode'] <= 3) {
            if (!isset($options->hostapd)) {
                $error = new ParseError('no hostap tag found', ErrorStore::$E_FATAL, $options);
                $errorstore->addError($error);
            }

            if ($options['mode'] == 2 && !isset($options->portal)) {
                $error = new ParseError('no portal tag found', ErrorStore::$E_FATAL, $options);
                $errorstore->addError($error);
            }

            if ($options['mode'] == 3) {
                if (!isset($options->openvpn)) {
                    $error = new ParseError('no openvpn tag found', ErrorStore::$E_FATAL, $options);
                    $errorstore->addError($error);
                }
                if(!isset($options->traffic_mode)){
                	$error = new ParseError('no Traffic mode tag found');
                	$errorstore->addError($error);
                }
            }

            /*
             * Check if all child tags are expected, throw error on unexpected tags
             */
            $this->checkChildNodes($options);
        } else {
            $error = new ParseError('invalid ssid mode ' . $options['mode'], ErrorStore::$E_FATAL, $options);
            $errorstore->addError($error);
        }
    }

}