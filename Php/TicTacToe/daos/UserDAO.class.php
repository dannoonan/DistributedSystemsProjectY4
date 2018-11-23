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
    
    public static function getUsername() {
		
        return $user->getUsername();
    }
    
}
    
?>