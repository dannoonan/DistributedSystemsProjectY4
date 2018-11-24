
<?php

class User{
	private $UserId;
	private $FirstName;
	private $LastName;
	private $Email;
	private $Password;
	private $Username;
  
	function setUserId($UserId) { $this->UserId = $UserId; }
	function getUserId() { return $this->UserId; }
	function setFirstName($FirstName) { $this->FirstName = $FirstName; }
	function getFirstName() { return $this->FirstName; }
	function setLastName($LastName) { $this->LastName = $LastName; }
	function getLastName() { return $this->LastName; }
	function setEmail($Email) { $this->Email = $Email; }
	function getEmail() { return $this->Email; }
	function setPassword($Password) { $this->Password = $Password; }
	function getPassword() { return $this->Password; }
	function setUsername($Username) { $this->Username = $Username; }
	function getUsername() { return $this->Username; }
	
}

?>

