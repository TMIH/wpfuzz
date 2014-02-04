<?php

	/**
	 *	Message Manager class
	 *
	 *	This class should be used whenever one wants to store
	 *	error messages or notices, it is based on PHP's predefined 
	 *	constants (ie. E_ERROR, E_WARNING, E_NOTICE, etc.)
	 *
	 *	Feel free to add more use cases at will!
	 *	TODO: We should add a "Humanly readable" display function,
	 *		so we can easily save this manager's report in a file, for example.
	 *	TODO: Integrate this class with the rest of the code.... :p
	 */


	class errorManager {
		
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
		
		function report($description,$level=E_WARNING,$generate_backtrace=true) {
			if($level & $this->filter){
				$report['description'] = $description;
				if($generate_backtrace)
					$report['backtrace'] = debug_backtrace();
				else
					$report['backtrace'] = 'Disabled';
				
				$this->msg[] = json_encode($report);
			}
		}
		
		function getReports() {
			return $msg;
		}
		
	}

?>
