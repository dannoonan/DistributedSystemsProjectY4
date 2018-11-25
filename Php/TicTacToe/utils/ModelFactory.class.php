<?php
require_once __DIR__.'//../models/Task.class.php';
require_once __DIR__.'//../models/User.class.php';
require_once __DIR__.'//../models/Tag.class.php';

class ModelFactory {
	//The public function is the interaction point between the other classes and the ModelFactory class, it provides an interface between
	//those classes and the private classes that we want to remain encapsulated
    public static function buildModel($modelName, $modelData) {

        $retVal = null;
		//Depending on the string passed as an arg to the buildModel funtion, either the createUser or createTask function will be called
        switch($modelName) {
             case "User":
                $retVal = self::createUser($modelData);
                break;
			case "Tag":
               $retVal = self::createTag($modelData);
                break;
			case "Task":
                $retVal = self::createTask($modelData);
                break;
			case "PdfFile":
				$retVal = self::PdfFile($modelData);
				break;
			default:
                echo "Unable to build model $modelName";
		}
		
		return $retVal;
    }

	private static function createUser($modelData) {
		//User object is created
		
		$retVal = new User();
		//If the UserId field is not set, then the value is set to that of the same field in the modelData
		if (isset($modelData['UserId'])) {
			
			$retVal ->setUserId($modelData["UserId"]);
		}
		//The same goes for the FirstName field, and all subsequent fields 
		if (isset($modelData['FirstName'])) {
			
			$retVal ->setFirstName($modelData["FirstName"]);
		}
		
		if (isset($modelData['LastName'])) {
			
			$retVal ->setLastName($modelData["LastName"]);
		}	

		if (isset($modelData['Email'])) {
			$retVal ->setEmail($modelData["Email"]);
		}
		
		if (isset($modelData['Course'])) {
			$retVal ->setCourse($modelData["Course"]);
		}
		
		if (isset($modelData['Password'])) {
			$retVal ->setPassword($modelData["Password"]);
		}
		if (isset($modelData['Reputation'])) {
			$retVal ->setReputation($modelData["Reputation"]);
		}
		//The new User object is returned
		return $retVal;
	}
	
	private static function createTag($modelData) {
		//User object is created
		$retVal = new Tag();
		//If the TagId field is not set, then the value is set to that of the same field in the modelData
		if (isset($modelData['TagId'])) {
			$retVal ->setTagId($modelData["TagId"]);
		}
		
		if (isset($modelData['Tag'])) {
			$retVal ->setTag($modelData["Tag"]);
		}
		
		//The new Tag object is returned
		return $retVal;
	}
	
	private static function createTask($modelData) {
		$retVal = new Task();
		
		if (isset($modelData['TaskId'])) {
			$retVal ->setTaskId($modelData["TaskId"]);
		}

		if (isset($modelData['Title'])) {
			$retVal ->setTitle($modelData["Title"]);
		}
		
		if (isset($modelData['TaskType'])) {
			$retVal ->setTaskType($modelData["TaskType"]);
		}
		
		if (isset($modelData['Description'])) {
			$retVal ->setDescription($modelData["Description"]);
		}	

		if (isset($modelData['Pages'])) {
			$retVal ->setPages($modelData["Pages"]);
		}

		if (isset($modelData['Words'])) {
			$retVal ->setWords($modelData["Words"]);
		}
		
		if (isset($modelData['FileFormat'])) {
			$retVal ->setFileFormat($modelData["FileFormat"]);
		}
		
		if (isset($modelData['FilePath'])) {
			$retVal ->setFilePath($modelData["FilePath"]);
		}
		
		if (isset($modelData['ClaimDate'])) {
			$retVal ->setClaimDate($modelData["ClaimDate"]);
		}

		if (isset($modelData['CompleteDate'])) {
			$retVal ->setCompleteDate($modelData["CompleteDate"]);
		}	

		if (isset($modelData['Notes'])) {
			$retVal ->setNotes($modelData["Notes"]);
		}
			
		return $retVal;
	}
	
	private static function PdfFile($modelData)
	{
		$retVal = new PdfFile();
	
		if (isset($modelData['fileId'])) {
			echo "t1";
			$retVal ->setFileId($modelData["fileId"]);		
		}
		
		if (isset($modelData['fileName'])){
			$retVal ->setFileName($modelData["fileName"]);
			echo "t2";
		}
		
		if (isset($modelData['tmpName'])){
			$retVal ->setTmpName($modelData["tmpName"]);
		}
		
		if (isset($modelData['fileSize'])){
			$retVal ->setFileSize($modelData["fileSize"]);
		}
		
		if (isset($modelData['fileType'])){
			$retVal ->setFileType($modelData["fileType"]);
		}
		
		if (isset($modelData['content'])){
			$retVal ->setContent($modelData["content"]);
		}
		
		return $retVal;
	}

}
?>