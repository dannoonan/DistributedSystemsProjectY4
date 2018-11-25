<?php 
	require_once __DIR__.'/../daos/TaskDAO.class.php';   
	require_once __DIR__.'/../models/Task.class.php';
class MySQLiAccess {

	
	private $error_msg     = '';
	private $connection;
	private static $instance = null;
	
	
	private function __construct() {
		$this->openConnection();
	}
	
	public static function getInstance() {
        if (!is_null(MySQLiAccess::$instance)) {
            return MySQLiAccess::$instance;
        } else {
            MySQLiAccess::$instance = new MySQLiAccess();
            return MySQLiAccess::$instance;
        }
    }
	
    private function openConnection() {
		$conn = false;
		$ret = false;
        $dbName = "gradeace";	//Settings::get('database.database');
        $server = "localhost";  //Settings::get('database.server');
		//Username can be changed accordingly
        $username = "root";	    //Settings::get('database.username');
        $password = "";	        //Settingstings::get('database.password');
		$conn = new mysqli($server, $username, $password, $dbName);
		
		unset($password); unset($dbName); unset($server);  unset($username);
		
		if (!$conn) {
            $this->error_msg = "\r\n" . "Unable to connect to database - " . date('H:i:s');
            $ret = false;
        } else {
            $this->connection = $conn;
            $ret = true;
        }
        return $ret;
	}
	
	public static function call($procedure, $procArgs) {
        $db = MySQLiAccess::getInstance();

		
        if (!is_array($procArgs)&& !is_null($procArgs)) {
            $sql = "CALL $procedure ($procArgs)";
			if($procedure == "getFile")
			echo $sql;
        } else if (!is_null($procArgs)) {
            $sql = "CALL $procedure ".implode(', ',$procArgs);
        }else{
			$sql = "CALL $procedure";
		}
        
		if($procArgs=="claimTask"){
			$db = MySQLiAccess::getInstance();
		}
		
		
        if ((empty($sql)) || (empty($db->connection))) {
            $db->error_msg = "\r\n" . "SQL Statement or connect is <code>null</code>" . date('H:i:s');
            return false;
        }
        
        $conn = $db->connection;
        $data = array();
		$newResult = array();

		if ($result = $conn->query($sql)) {
			
			if($result){

				$newResult = $result;
			}
        }else{
			echo "Fail////";
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		 
		 return empty($newResult) ? false : $newResult;
		
		
		//return empty($data) ? false : $data;

    }
	
	public static function call2 ($procedure, $procArgs){
		$conn = false;
		$ret = false;
        $dbName = "gradeace";	//Settings::get('database.database');
        $server = "localhost";  //Settings::get('database.server');
		//Username can be changed accordingly
        $username = "root";	    //Settings::get('database.username');
        $password = "";	        //Settingstings::get('database.password');
		$conn = mysqli_connect($server, $username, $password, $dbName);
		
		unset($password); unset($dbName); unset($server);  unset($username);
		
		if (!is_array($procArgs)&& !is_null($procArgs)) {
            $sql = "CALL $procedure ($procArgs)";
        } else if (!is_null($procArgs)) {
            $sql = "CALL $procedure ".implode(', ',$procArgs);
        }else{
			$sql = "CALL $procedure";
		}

		$result = mysqli_query($conn, $sql);
		
		if($result){
			$ret = $result;

		}else{
			$ret = false;

			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		return $ret;
	}
	
	public static function prepareString($string) {
		$db = MySQLiAccess::getInstance();
		$conn = $db->connection;
		$string2 = $conn->real_escape_string($string);
		$x="'".$string2."'";
		return $x;
	}
	
	public static function Download($TaskId){
        $conn = false;
		$ret = false;
        $dbName = "gradeace";	//Settings::get('database.database');
        $server = "localhost";  //Settings::get('database.server');
		//Username can be changed accordingly
        $username = "root";	    //Settings::get('database.username');
        $password = "";	        //Settingstings::get('database.password');
		$conn = mysqli_connect($server, $username, $password, $dbName);
		
		unset($password); unset($dbName); unset($server);  unset($username);
		
		$TaskDAO=new TaskDAO();
		$task=$TaskDAO->getTask($TaskId);
		$FileId=$task->getFilePath();
		
		$query = "SELECT * FROM upload WHERE fileId = $FileId";
		$result = mysqli_query($conn,$query) 
                     or die('Error, query failed');
		list($id, $file, $type, $size,$content) =   mysqli_fetch_array($result);
           //echo $id . $file . $type . $size;
		header("Content-length: $size");
		header("Content-type: $type");
		header("Content-Disposition: attachment; filename=$file");
		ob_clean();
		flush();
		echo $content;
		mysqli_close($connection);
		exit;
	}

} 
?>
