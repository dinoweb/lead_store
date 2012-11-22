<?php
class Language {
	private $default = 'english';
	private $directory;
	private $data = array();
 
	public function __construct($directory) {
		$this->directory = $directory;
	}
	
  	public function get($key) {
   		return (isset($this->data[$key]) ? $this->data[$key] : $key);
  	}
	
	public function load($filename) {
		
		$loaded = FALSE;
		
		$file = DIR_LANGUAGE . $this->default . '/' . $filename . '.php';
		
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
		
			$this->data = array_merge($this->data, $_);
			$loaded = TRUE;
			
		}
		
		$file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';
    	
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
		
			$this->data = array_merge($this->data, $_);
			$loaded = TRUE;
		}

		$file = DIR_LOCAL_LANGUAGE . $this->default . '/' . $filename . '.php';
    	
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
		
			$this->data = array_merge($this->data, $_);
			$loaded = TRUE;
			
		}

		$file = DIR_LOCAL_LANGUAGE . $this->directory . '/' . $filename . '.php';
    	
		if (file_exists($file)) {
			$_ = array();
	  		
			require($file);
		
			$this->data = array_merge($this->data, $_);
			$loaded = TRUE;
			
		}

		if (!$loaded)
		{
			trigger_error('Error: Could not load language ' . $filename . '!');
			exit();
		}

		return $this->data;

  	}
}
?>