<?php
/**
* Main class for MUFFIN, holds everything.
*
* @package MUFFINCore
*/

class CMUFFIN implements ISingleton {

   private static $instance = null;
   
	/**
	* Constructor
	*/
   protected function __construct() {
      // include the site specific config.php and create a ref to $mu to be used by config.php
      $mu = &$this;
      require(MUFFIN_SITE_PATH.'/config.php');
   }
	
   /**
    * Frontcontroller, check url and route to controllers.
    */
  public function FrontControllerRoute() {
    // Step 1
    // Take current url and divide it in controller, method and parameters
    $this->request = new CRequest();
    $this->request->Init();
    $controller = $this->request->controller;
    $method     = $this->request->method;
    $arguments  = $this->request->arguments;
	
	$controllerExists    = isset($this->config['controllers'][$controller]);
    $controllerEnabled   = false;
    $className           = false;
    $classExists         = false;

    if($controllerExists) {
      $controllerEnabled    = ($this->config['controllers'][$controller]['enabled'] == true);
      $className               = $this->config['controllers'][$controller]['class'];
      $classExists           = class_exists($className);
    }
	
    // Step 2
    // Check if there is a callable method in the controller class, if then call it

    if($controllerExists && $controllerEnabled && $classExists) {
      $rc = new ReflectionClass($className);
      if($rc->implementsInterface('IController')) {
        if($rc->hasMethod($method)) {
          $controllerObj = $rc->newInstance();
          $methodObj = $rc->getMethod($method);
          $methodObj->invokeArgs($controllerObj, $arguments);
        } else {
			$arr = get_defined_vars();
			// print $b
			print_r($arr);

          die("404. " . get_class() . ' error: Controller does not contain method.');
		  
        }
      } else {
        die('404. ' . get_class() . ' error: Controller does not implement interface IController.');
      }
    } 
    else { 
      die('404. Page is not found.');
    }
  }
	/**
    * Theme Engine Render, renders the views using the selected theme.
    */
  public function ThemeEngineRender() {
    echo "<h1>I'm CMuffin::ThemeEngineRender</h1><p>You are most welcome. Nothing to render at the moment</p>";
    echo "<h2>The content of the config array:</h2><pre>", print_r($this->config, true) . "</pre>";
    echo "<h2>The content of the data array:</h2><pre>", print_r($this->data, true) . "</pre>";
    echo "<h2>The content of the request array:</h2><pre>", print_r($this->request, true) . "</pre>";
  }

   /**
    * Singleton pattern. Get the instance of the latest created object or create a new one. 
    * @return CMUFFIN The instance of this class.
    */
   public static function Instance() {
      if(self::$instance == null) {
         self::$instance = new CMUFFIN();
      }
      return self::$instance;
   }
   
   }