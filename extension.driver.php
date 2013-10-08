<?php

	Class extension_lang_dutch extends Extension {
		
		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#getSubscribedDelegates
		 */
		public function getSubscribedDelegates(){
			return array(
				array(
					'page' => '/system/preferences/',
					'delegate' => 'Save',
					'callback' => '__toggleDutch'
				)
			);
		}
		
		/**
		 * Toggle between Dutch and default date and time settings
		 */
		public function __toggleGerman($context) {
			
			// Set German date and time settings
			if($context['settings']['symphony']['lang'] == 'nl') {
				$this->__setDutch();
			}
			
			// Restore default date and time settings
			else {
				$this->__unsetDutch();
			}
		}
		
		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#install
		 */
		public function install() {
		
			// Fetch current date and time settings
			$date = Symphony::Configuration()->get('date_format', 'region');
			$time = Symphony::Configuration()->get('time_format', 'region');
			$separator = Symphony::Configuration()->get('datetime_separator', 'region');
			
			// Store current date and time settings
			Symphony::Configuration()->set('date_format', $date, 'lang-dutch-storage');
			Symphony::Configuration()->set('time_format', $time, 'lang-dutch-storage');
			Symphony::Configuration()->set('datetime_separator', $separator, 'lang-dutch-storage');
			Administration::instance()->saveConfig();
		}

		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#enable
		 */
		public function enable(){
			if(Symphony::Configuration()->get('lang', 'symphony') == 'nl') {
				$this->__setDutch();
			}
		}

		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#disable
		 */
		public function disable(){
			$this->__unsetDutch();
		}

		/**
		 * @see http://symphony-cms.com/learn/api/2.3/toolkit/extension/#uninstall
		 */
		public function uninstall() {
			$this->__unsetDutch();

			// Remove storage
			Symphony::Configuration()->remove('lang-dutch-storage');
			Administration::instance()->saveConfig();
		}
		
		/**
		 * Set German date and time format
		 */
		private function __setDutch() {
		
			// Set German date and time settings
			Symphony::Configuration()->set('date_format', 'd. F Y', 'region');
			Symphony::Configuration()->set('time_format', 'H:i', 'region');
			Symphony::Configuration()->set('datetime_separator', ', ', 'region');			
			Administration::instance()->saveConfig();
		}
		
		/**
		 * Reset default date and time format
		 */
		private function __unsetDutch() {
		
			// Fetch current date and time settings
			$date = Symphony::Configuration()->get('date_format', 'lang-dutch-storage');
			$time = Symphony::Configuration()->get('time_format', 'lang-dutch-storage');
			$separator = Symphony::Configuration()->get('datetime_separator', 'lang-dutch-storage');	
			
			// Store new date and time settings
			Symphony::Configuration()->set('date_format', $date, 'region');
			Symphony::Configuration()->set('time_format', $time, 'region');
			Symphony::Configuration()->set('datetime_separator', $separator, 'region');
			Administration::instance()->saveConfig();
		}

	}
	