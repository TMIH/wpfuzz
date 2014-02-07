<?php

	/**
	 *	Message Manager class
	 *
	 *	This class should be used whenever one wants to store
	 *	error messages or notices, it is based on PHP's predefined 
	 *	constants (ie. E_ERROR, E_WARNING, E_NOTICE, etc.)
	 *
	 *	Feel free to add more use cases at will!
	 *
	 *	TODO: Integrate this class with the rest of the code.... :p
	 */


	class messageManager {
		
		public $filter;	// INT (ORed constants)
		private $msg; // JSON String array, FIFO order
		
		/*
		*	When instantiating this class, it is possible to modify 
		*	what type of messages will get displayed by setting a valid
		* "or'ed" constant as this constructor's parameter
		*/
		
		function __construct($filter=E_ALL){
			$this->msg = array();
			$this->filter = $filter;
		}
		
		/*
		*	$description = Text description of the issue
		* $level = PHP constant under which this report should be filed
		* $generate_backtrace = By default, this function keeps track of where
		*		a report comes from, set to FALSE if this is not a desired behaviour
		*/
		
		function report( $description , $level = E_WARNING , $generate_backtrace = true ) {
			if( $level & $this->filter ){
				$report['description'] = $description;
				if($generate_backtrace)
					$report['backtrace'] = debug_backtrace();
				else
					$report['backtrace'] = 'Disabled';
				
				$this->msg[] = json_encode( $report );
			}
		}
		
		function getHumanReadableReports($NL = "<br />") {
		  $dbgTrace = $this->getReports();
		  $dbgMsg = $NL."=========== REPORT BEGINNING ===========$NL";
		  foreach( $dbgTrace as $reports ){
				$reports = json_decode( $reports, true );
				foreach( $reports['backtrace'] as $dbgIndex => $dbgInfo ) {
						$dbgMsg .= "\t at $dbgIndex  ".$dbgInfo['file'];
						$dbgMsg .= " (line ".$dbgInfo['line'].") -> ".$dbgInfo['function']."(".join(",",$dbgInfo['args']).")$NL";
				}
			}
		  
		  $dbgMsg .= 	"=========== END OF REPORT ===========".$NL;
		  return $dbgMsg;
		}
		
		function getReports() {
			
			return $this->msg;
		}
		
	}

	$msgman = new messageManager(__LOGGINGLEVEL__); 

	/**
	*		Procedural wrappers for our class, might be useful
	*/
	
	function report( $msg , $level = E_WARNING ){
		global $msgman;
		$msgman->report($msg,$level);
	}
	
	function getReports(){
		global $msgman;
		return $msgman->getReports();		
	}
	
	function getHumanReadableReports() {
		global $msgman;
		return $msgman->getHumanReadableReports();
	}

?>
