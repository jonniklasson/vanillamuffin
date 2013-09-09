<?php
/**
* Parse the request and identify controller, method and arguments.
*
* @package MuffinCore
*/
class CRequest {

  /**
   * Init the object by parsing the current url request.
   */
  public function Init($baseUrl = null) {

    // Take current url and divide it in controller, method and arguments
	
	$requestUri = $_SERVER['REQUEST_URI'];
    $scriptName = $_SERVER['SCRIPT_NAME']; 
    $query = substr($_SERVER['REQUEST_URI'], strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')));
    $splits = explode('/', trim($query, '/'));

    // Set controller, method and arguments	
    $controller =  !empty($splits[0]) ? $splits[0] : 'index';
	$method    =  !empty($splits[1]) ? $splits[1] : 'index';
    $arguments = $splits;
    unset($arguments[0], $arguments[1]); // remove controller & method part from argument list
	
	// Prepare to create current_url and base_url
	$currentUrl = $this->GetCurrentUrl();
	$parts        = parse_url($currentUrl);
	$baseUrl       = !empty($baseUrl) ? $baseUrl : "{$parts['scheme']}://{$parts['host']}" . (isset($parts['port']) ? ":{$parts['port']}" : '') . rtrim(dirname($scriptName), '/');
	      
    // Store it
    $this->base_url      = rtrim($baseUrl, '/') . '/';
	$this->current_url  = $currentUrl;
	$this->request_uri  = $_SERVER['REQUEST_URI'];
    $this->script_name  = $_SERVER['SCRIPT_NAME'];
    $this->query        = $query;
    $this->splits       = $splits;
    $this->controller   = $controller;
    $this->method       = $method;
    $this->arguments    = $arguments;

	}
  
    /**
   * Get the url to the current page. 
   */
  public function GetCurrentUrl() {
    $url = "http";
    $url .= (@$_SERVER["HTTPS"] == "on") ? 's' : '';
    $url .= "://";
    $serverPort = ($_SERVER["SERVER_PORT"] == "80") ? '' :
    (($_SERVER["SERVER_PORT"] == 443 && @$_SERVER["HTTPS"] == "on") ? '' : ":{$_SERVER['SERVER_PORT']}");
    $url .= $_SERVER["SERVER_NAME"] . $serverPort . htmlspecialchars($_SERVER["REQUEST_URI"]);
    return $url;
  }

} 
