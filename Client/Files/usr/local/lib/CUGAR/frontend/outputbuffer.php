<?php
class outputBuffer{
	/**
	 * 
	 */
	private $buffer;
	
	/**
	 * Boolean flag for errors
	 * 
	 * @var Boolean
	 */
	private $errors;
	
	public function outputBuffer(){
		$this->buffer = new SimpleXMLElement('reply');
		$this->buffer->addAttribute('action','');
	}
	
	/**
	 * return $this->errors boolean
	 */
	public function hasErrors(){
		return $this->errors;
	}
	
	/**
	 * 
	 * @param unknown_type $errormessage
	 */
	public function addError($errormessage){
		$this->errors = true;
		$error = $this->buffer->addChild('error');
		$error->addChild('message',$errormessage);
	}
	
	/**
	 * 
	 * @param unknown_type $errormessage
	 * @param unknown_type $formfield
	 */
	public function addFormError($formfield,$errormessage){
		$this->errors = true;
		$error = $this->buffer->addChild('formfield');
		$error->addAttribute('id',$formfield);
		$error->addChild('message',$errormessage);
	}
	
	/**
	 * echo the output to screen.
	 */
	public function returnOutput(){
		if($this->errors){
			$this->buffer['action'] = 'error';
		}
		else{
			$this->buffer['action'] = 'ok';
		}
		
		echo $this->buffer->asXML();
	}
}