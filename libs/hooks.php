<?php

	/**
	*
	*	Contains a list of all default hooks WordPress uses.
	* Useful to know what hook was added by third-party plugins.
	*
	*/

	class WPFuzzHooks {
		private $defaultHooks; // Hooks and associated functions already used by WordPress
		public	$currentHooks;
		
		function __construct() {
			$this->loadDefaultHooks();
		}
		
		function loadDefaultHooks(){
			$base_hooks = __WPFUZZ__ . "/data/base_hooks";
			if( file_exists( $base_hooks ) ) {
				$this->defaultHooks = json_decode( file_get_contents( $base_hooks ) , true );
			}
			else {
				// TODO: Prepare a _cute_ error report manager so we get through the "die(URMSGHERE)" temptation
				$this->defaultHooks = array();
			}
		}
		
		function loadCurrentHooks() {
			global $wp_filter;
			$this->currentHooks = json_encode( $wp_filter );
		}
		
	}
	

?>
