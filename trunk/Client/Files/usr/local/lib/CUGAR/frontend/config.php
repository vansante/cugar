<?php
/*
 All rights reserved.
 Copyright (C) 2010-2011 CUGAR
 All rights reserved.

 All rights reserved.
 Copyright (C) 2009-2010 GenericProxy <feedback@genericproxy.org>.
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
 * Create an object from config.xml
 *
 * Original author:
 * @author Sebastiaan Gibbon
 * @version 0
 */
class Config {

        /**
         * @var SimpleXMLElement Config in a XML object
         */
        public $xml;

        /**
         * @var string Filename of the configuration file.
         */
        public $file;

        /**
         * Opens a configuration file
         * 
         * @param string $file URI to the file to be opened.
         * @throws Exception on failing to load.
         */
        public function __construct($file){
                $previouslibxmlSetting = libxml_use_internal_errors(true);// Using custom error throwing.

                $this->xml = simplexml_load_file($file);
                $this->file = $file;

                //Failed loading the XML, throw excption.
                if (!$this->xml){
                        $message = "Failed to load configuration file {$file}. Invalid XML. ";
                        foreach(libxml_get_errors() as $error) {
                                $message .= $error->message;
                        }
                                
                        libxml_clear_errors();
                        throw new Exception($message);
                }

                libxml_use_internal_errors($previouslibxmlSetting);//Set back to default
        }

        /**
         * Saves the configuration to file.
         * 
         * @param string $file leave empty to use original file or specify another file.
         * @return bool Returns TRUE on success.
         */
        public function saveConfig($file = null) {
                Functions::shellCommand('mount /cfg');
                $file = is_null($file) ? $this->file : $file;
                $return = $this->xml->asXML($file);
                if(!is_dir('/cfg/CUGAR')){
                       Functions::shellCommand('mkdir /cfg/CUGAR');
                }
                Functions::shellCommand('cp -r /etc/CUGAR/* /cfg/CUGAR/');
              	Functions::shellCommand('umount /cfg');
                return $return;
        }

        /**
         * Get a specific tag, found in the root of the config file.
         * 
         * If the element does not exist, one will be created.
         * If name is null, or not given, the root XML tag will be returned.  
         * 
         * @param string $name Name of the XML tag.
         * @return SimpleXMLElement
         */
        public function getElement($name){
                if (empty($name)){
                        return $this->xml;
                } elseif ($this->xml->{$name}[0]){
                        return $this->xml->{$name}[0];
                } else {
                        return $this->xml->addChild($name);
                }
        }

        /**
         * Delete a specific tag found in the root or remove the SimpleXMLElement node from the config.
         * 
         * @param string|SimpleXMLElement $node Node of the XML tag to be removed.
         * @return void
         */
        public function deleteElement($node){
                if (is_string($node)){
                        unset($this->xml->{$node}[0]);
                } elseif ($node instanceof SimpleXMLElement){
                        $dom=dom_import_simplexml($node);
                        $dom->parentNode->removeChild($dom);
                }
        }
}
?>