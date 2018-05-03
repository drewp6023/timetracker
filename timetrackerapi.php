<?php

if (!empty($_POST)) {
	print "We are working";
}

class Database {
	
	protected $host;
	protected $username;
	protected $password;
	protected $databasename;
	protected $conn;

	public function __construct($options = [])
	{
		if (!empty($options) && is_array($options)) {
			if (isset($options['host'])) $this->host = $options['host'];
			if (isset($options['username'])) $this->username = $options['username'];
			if (isset($options['password'])) $this->password = $options['password'];
			$this->databasename = isset($options['databasename']) ? $options['databasename'] : '';
		}

		// Make a db connection
		$this->connect($this->databasename);
	}

	public function __destruct()
	{
		mysql_close($this->conn);
	}

	private function connect()
	{
		$this->conn = mysqli_connect($this->host, $this->username, $this->password, $databasename = '');

		// Check connection
		if ($this->conn === false) {
			return mysqli_connect_error();
		} 

		if (!empty($databasename)) mysql_select_db($this->conn, $databasename);
	}

	public function query($sql)
	{
		$rs = mysqli_query($this->conn, $sql);

	   	$results = array();
        while ($row = mysqli_fetch_object($rs)) {
            foreach ($row as $c => $v) {
                $row->$c = htmlspecialchars($v);
            }
            $results[] = $row;
        }

        mysqli_free_result($rs);
        
        return $results;
	}
}