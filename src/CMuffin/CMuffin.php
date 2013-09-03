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
    * ThemeEngineRender, renders the reply of the request.
    */
  public function ThemeEngineRender() {
    // Get the paths and settings for the theme
    $themeName    = $this->config['theme']['name'];
    $themePath    = MUFFIN_INSTALL_PATH . "/themes/{$themeName}";
    $themeUrl      = "themes/{$themeName}";
   
    // Add stylesheet path to the $mu->data array
	
    $this->data['stylesheet'] = "{$themeUrl}/style.css";

    // Include the global functions.php and the functions.php that are part of the theme
    $mu = &$this;
    $functionsPath = "{$themePath}/functions.php";
    if(is_file($functionsPath)) {
      include $functionsPath;
    }

    // Extract $ly->data to own variables and handover to the template file
    extract($this->data);     
    include("{$themePath}/default.tpl.php");
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