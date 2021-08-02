<?
	/**
	 * This class is used to access a MySQL database
	 *
	 * @package Huy's
	 * @author  Huy
	 */

	class admin extends huy {

		protected $config;

		public function __construct(array $config){
        	$this->config = $config;
	    }

		function listLocale(){
			$dir    = ROOT_DIR.'/locales';
			$files = scandir($dir);
			foreach($files as $file){
				$name = explode('.',$file);
				$name = $name[0];
				if($name != NULL){ echo "<option value='$name' ".($this->config[locale] == $name ? 'selected' : '').">".ucfirst($name)."</option>"; }
			}
		}
		function listAPP($apps){
			foreach($apps as $key => $value){
				echo "<option value='$value' ".($this->config[default_app] == $value ? 'selected' : '').">".$key."</option>"; 
			}
		}

	}