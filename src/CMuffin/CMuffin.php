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

    // Step 2
    // Check if there is a callable method in the controller class, if then call it

  }
	/**
    * Theme Engine Render, renders the views using the selected theme.
    */
  public function ThemeEngineRender() {
    echo "<h1>I'm CLydia::ThemeEngineRender</h1><p>You are most welcome. Nothing to render at the moment</p>";
    echo "<pre>", print_r($this->data, true) . "</pre>";
 
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