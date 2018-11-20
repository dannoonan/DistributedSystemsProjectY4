
<?php

class Proxy{
	private $client;
        private $wsdl = "http://localhost:8080/TTTWebApplication/TTTWebService?WSDL";
        private $trace = true;
        private $exceptions = true;
	
  
	function setClient() { $this->client = new SoapClient($this->wsdl, array('trace' => $this->trace, 'exceptions' => $this->exceptions)); }
	function getClient() { return $this->client; }
	
	
}

?>

