<?php
class Functions{
	/**
	 * Execute shell command
	 *
	 * @static
	 * @access public
	 * @param string $command Command to execute
	 * @param string $errors Errors from STRERR. Returns empty string when there have been no errors.
	 * @param int $returncode Command return code
	 * @param string $input Input to be used to feed to the command.
	 * @return string Returns all the output of the command
	 */
	public static function shellCommand($command, &$errors = null, &$returncode = null, $input = null) {
		$descriptorspec [0] = array ("pipe", "r" ); // stdin is a pipe that the child will read from
		$descriptorspec [1] = array ("pipe", "w" ); // stdout is a pipe that the child will write to
		$descriptorspec [2] = array ("pipe", "w" ); // stderr is a pipe that the child will write to

		//Open and execute command
		$process = proc_open ( $command, $descriptorspec, $pipes, null, $_ENV );

		if (is_resource ( $process )) {
			if (isset ( $input )) {
				fwrite ( $pipes [0], $input );
			}
			fclose ( $pipes [0] );

			$output = trim ( stream_get_contents ( $pipes [1] ) );
			fclose ( $pipes [1] );

			$errors = trim ( stream_get_contents ( $pipes [2] ) );
			fclose ( $pipes [2] );

			// It is important that you close any pipes before calling
			// proc_close in order to avoid a deadlock
			$returncode = proc_close ( $process );

			//	DEBUG
			echo $command;
			//	DEBUG
			
			return $output;
		}
	}

	/**
	 * Get interface list
	 * 
	 * Returns an array of interfaces as grepped from the ifconfig command
	 * as such this includes ALL interfaces (other than loopback which is filtered out)
	 * element 0 in the returned array is typically the first ethernet device (i.e. the one with
	 * internet connectivity)
	 *
	 * @return Array
	 */
	public static function getInterfaceList() {
		$i = 0;
		$interfaces = array();

		$temp = Functions::shellCommand('ifconfig');
		$temp = explode("\n",$temp);

		while($i < count($temp)){
			if(stristr($temp[$i],'flags')){
				$position = strpos($temp[$i],":",0);
				$tmp = substr($temp[$i],0,$position);

				if($tmp != 'lo0'){
					$interfaces[] = $tmp;
				}
			}
			$i++;
		}
		return $interfaces;
	}
}