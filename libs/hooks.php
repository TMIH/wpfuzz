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
            		$this->loadCurrentHooks();
            		$this->filterHooks();
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

		function filterHooks() {
			$hooks = json_decode( $this->currentHooks, true );
			$currenthooks_name = $this->fillArray($hooks);
			$defaulthooks_name = $this->fillArray($this->defaulthooks);
			$valid_hooks = array();							
			
			
			foreach ( $currenthooks_name as $hook => $filter ) {
				if (in_array( $hook, $defaulthooks_name ) === FALSE ) {
					$valid_hooks[] = $hook;

					foreach ( $filter as $key => $value ) {
						$valid_hooks[$hook] = $key;					
					}
				}
				else {
					foreach ( $filter as $key => $value ) {
						if ( in_array( $key, $defaulthooks_name[$hook] ) === FALSE ) {
							$valid_hooks[] = $hook;
							$valid_hooks[$hook] = $key;					
						}
					}
				}							
			}
			return $valid_hooks;
		}

		function fillArray($hooks) {
			$return_array = array();
			foreach ( $hooks as $hook_name => $action ) {
               			 $return_array[] = $hook_name;
               			 foreach ( $action as $key => $value ) {
					$return_array[$hook_name][] = $key;	
                		 }
			}

			return $return_array;
		}	
	}
?>
