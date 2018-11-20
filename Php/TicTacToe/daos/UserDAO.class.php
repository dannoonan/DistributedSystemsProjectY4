<?php
require_once __DIR__.'/../models/User.class.php';


class UserDAO {
    public static function setUser($UserId) {
		
        $user = new User();
        $user->setUserId($UserId);
        return $user;
    }
    
    public static function getUserID() {
		
        return $user->getUserId();
    }
    
	public static function save($user) {
       if (is_null($user->getUserId())) {
            self::insert($user);
       }/*else {
            self::update($user);
        }*/
        return $user;
    }
	
	private static function insert(&$user) {
		$siteSalt  = "gradeace";
		$saltedHash = hash('sha256', $user->getPassword().$siteSalt);
		
		$args = 
		MySQLiAccess::prepareString($user->getFirstName()).", ".
		MySQLiAccess::prepareString($user->getLastName()).", ".
		MySQLiAccess::prepareString($user->getEmail()).", ".
		MySQLiAccess::prepareString($user->getCourse()).", ".
		MySQLiAccess::prepareString($saltedHash);

		$result = MySQLiAccess::call("addUser", $args);
        if ($result) {
            $user = ModelFactory::buildModel("User", $result[0]);
        } else {
            $user = null;
        }
    }

	public static function login($username, $password) {

		
		$user = self::getUser("''",$username);
		
		if (!is_null($user)) {
			$id = $user->getUserId();
				return $user;
		}
	}
	
	public static function logout() {
		/*http://php.net/manual/en/function.session-unset.php*/
		if (!isset ($_SESSION)) {
			session_start();
		}
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		//session_regenerate_id(false);	
	}	
}
?>