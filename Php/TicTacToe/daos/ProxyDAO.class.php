<?php
require_once __DIR__.'/../models/Proxy.php';


class ProxyDAO {
    public static function setClient() {
		
        $client = new Proxy();
        $client->setClient();
    }
    
    public static function getUserID() {
		
        return $client->getClient();
    }
}
?>