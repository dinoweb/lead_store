<?php
class DB {
	private $driver;
	
	public function __construct($driver, $hostname, $username, $password, $database) {
		if (file_exists(DIR_LOCAL_DATABASE . $driver . '.php')) {
			require_once(DIR_LOCAL_DATABASE . $driver . '.php');
		} else {
			if (file_exists(DIR_DATABASE . $driver . '.php')) {
				require_once(DIR_DATABASE . $driver . '.php');
			} else {
				exit('Error: Could not load database file ' . $driver . '!');
			}
		}
				
		$this->driver = new $driver($hostname, $username, $password, $database);
	}
		
  	public function query($sql) {
		return $this->driver->query($sql);
  	}
	
	public function escape($value) {
		return $this->driver->escape($value);
	}

	public function countAffected() {
	return $this->driver->countAffected();
	}

	public function getLastId() {
	return $this->driver->getLastId();
	}

	public function beginTrans() {
		if (method_exists($this->driver, 'beginTrans'))
		{
			return $this->driver->beginTrans();
		}
	}	

	public function commitTrans() {
		if (method_exists($this->driver, 'commitTrans'))
		{
			return $this->driver->commitTrans();
		}
	}	

	public function rollbackTrans() {
		if (method_exists($this->driver, 'rollbackTrans'))
		{
			return $this->driver->rollbackTrans();
		}
	}

}
?>