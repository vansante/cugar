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
 * Interface for Statements to be parsed from the XML
 *
 */
abstract class Statement{
	/**
	 * Parsing options passes through from the parser or parent nodes
	 * @var integer
	 */
	protected $parse_options;
	
	/**
	 * Interpret the statement
	 * 
	 * Validates (through validate()) the statement and propagates their meaning to the
	 * configuration management classes through the approprate functions.
	 * 
	 * @throws MalformedConfigException
	 * @return void
	 */
	public abstract function interpret($options);
	
	/**
	 * Validate the statement
	 * 
	 * @throws MalformedConfigException
	 * @return void
	 */
	public abstract function validate($options);
		
	/**
	 * Load statement class
	 * @param String $classname
	 * @return void
	 */
	protected function loadClass($classname){
		if(file_exists('./parser/'.$classname.'.php')){
			require_once('./parser/'.$classname.'.php');
		}
		else{
			throw new SystemError('Could not load file '.$classname.'.php');
		}
	}
	
	
	/**
	 * Parse all the child tags of this statement
	 * 
	 * @param SimpleXMLElement $options
	 * @return void
	 */
	public function parseChildren($options){
		foreach($options->children() as $child){
			//	Interpret each child tag, and we're through (because SSID contains no system configuration and is merely a container)
			$name = $child->getName();
			
			$this->loadClass($name);
			if(class_exists($name)){
				if(in_array($child->getName(),$this->expectedtags)){
					$tmp = new $name($this->parse_options);
					$tmp->interpret($child);
				}
			}
			else{
				throw new SystemError('Could not find class '.$name);	
			}
		}
	}
}
?>