<?php
class Status{
	private $config;

	public function __construct($config){
		$this->config = $config;
	}

	/**
	 * 	Parse request
	 *
	 */
	public function parse(){
		$buffer = '<reply action="ok"><system>';

		//      Get name
		$buffer .= '<name>' .$this->config->getElement('hardware')->hostname. '</name>';
		$buffer .= '<version>' . Functions::VERSION . '</version>';

		$buffer .= '<uptime>' . $this->getUptime() . '</uptime>';

		//      Get processor
		$data = Functions::shellCommand ( 'uptime' );
		$data = explode ( ',', $data );
		$cpu = str_replace ( ' Load averages: ', $data [3] );
		$cpu = explode ( ',', $cpu );

		$buffer .= '<cpu>';
		$buffer .= '<avg15>' . round ( $cpu [2] * 100 ) . '</avg15>';
		$buffer .= '<avg5>' . round ( $cpu [1] * 100 ) . '</avg5>';
		$buffer .= '<avg1>' . round ( $cpu [0] * 100 ) . '</avg1>';
		$buffer .= '</cpu>';

		//      Get memory usage
		$totalram = str_replace ( 'hw.physmem: ', '', Functions::shellCommand ( 'sysctl hw.physmem' ) );
		$totalram = floor ( $totalram / (1024 * 1024) );
		$usedram = floor ( $totalram - $this->getFreeMemory () );
		$buffer .= '<memory><total>' . $totalram . '</total><used>' . $usedram . '</used></memory>';

		$buffer .= '</system></reply>';
		echo $buffer;
	}

	/**
	 * Get the system's uptime
	 * See: http://dev.kafol.net/2008/09/php-freebsd-uptime-status.html
	 *
	 * @return string uptime
	 */
	public function getUptime() {
		$s = explode(" ", exec("/sbin/sysctl -n kern.boottime") );
		$a = str_replace(",", "", $s[3]);
		return $this->getDuration($a);
	}

	/**
	 * Get the duration between 2 time stamps
	 * See: http://dev.kafol.net/2008/09/php-calculating-time-span-duration.html
	 * @static
	 * @return string duration
	 */
	public function getDuration($start, $end = false) {
		if (!$end) {
			$end = time();
		}
		$seconds = $end - $start;

		$days = floor($seconds / 60 / 60 / 24);
		$hours = $seconds / 60 / 60 %24;
		$mins = $seconds / 60 % 60;
		$secs = $seconds % 60;

		$duration='';
		if ($days > 0) {
			$duration .= "$days days ";
		}
		if ($hours > 0) {
			$duration .= "$hours hours ";
		}
		if ($mins > 0) {
			$duration .= "$mins minutes ";
		}
		if ($secs > 0) {
			$duration .= "$secs seconds ";
		}

		$duration = trim($duration);
		if ($duration == null) {
			$duration = '0 seconds';
		}

		return $duration;
	}

	/**
	 * Get the available free memory.
	 *
	 * @static
	 * @return int free memory
	 */
	public function getFreeMemory() {
		$pagesize = Functions::shellCommand ( "/sbin/sysctl -n hw.pagesize" );
		$freememory = Functions::shellCommand ( "/sbin/sysctl -n vm.stats.vm.v_free_count" );

		return round ( ($freememory * $pagesize) / (1024 * 1024) );
	}


}