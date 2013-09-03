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
  public function Init() {
    // Take current url and divide it in controller, method and arguments
    $query = substr($_SERVER['REQUEST_URI'], strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '/')));
    $splits = explode('/', trim($query, '/'));

    // Set controller, method and arguments

	
    $controller =  !empty($splits[0]) ? $splits[0] : 'index';
	$method    =  !empty($splits[1]) ? $splits[1] : 'index';
    $arguments = $splits;
    unset($arguments[0], $arguments[1]); // remove controller & method part from argument list
    
    // Store it
    $this->request_uri  = $_SERVER['REQUEST_URI'];
    $this->script_name  = $_SERVER['SCRIPT_NAME'];
    $this->query        = $query;
    $this->splits       = $splits;
    $this->controller   = $controller;
    $this->method       = $method;
    $this->arguments    = $arguments;
  }

}