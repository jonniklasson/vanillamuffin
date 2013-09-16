<?php
/**
* Holding a instance of CMuffin to enable use of $this in subclasses.
*
* @package MuffinCore
*/
class CObject {

   public $config;
   public $request;
   public $data;
   public $db;
   public $views;
   public $session;

   /**
    * Constructor
    */
   protected function __construct() {
    $mu = CMuffin::Instance();
    $this->config   = &$mu->config;
    $this->request  = &$mu->request;
    $this->data     = &$mu->data;
	$this->db       = &$mu->db;
	$this->views	= &$mu->views;
    $this->session  = &$mu->session;
  }
  
  	/**
	 * Redirect to another url and store the session
	 */
	protected function RedirectTo($urlOrController=null, $method=null) {
    $mu = CMuffin::Instance();
    if(isset($mu->config['debug']['db-num-queries']) && $mu->config['debug']['db-num-queries'] && isset($mu->db)) {
      $this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
    }    
    if(isset($mu->config['debug']['db-queries']) && $mu->config['debug']['db-queries'] && isset($mu->db)) {
      $this->session->SetFlash('database_queries', $this->db->GetQueries());
    }    
    if(isset($mu->config['debug']['timer']) && $mu->config['debug']['timer']) {
	    $this->session->SetFlash('timer', $mu->timer);
    }    
    $this->session->StoreInSession();
    header('Location: ' . $this->request->CreateUrl($urlOrController, $method));
  }

  /**
   * Redirect to a method within the current controller. Defaults to index-method. Uses RedirectTo().
   *
   * @param string method name the method, default is index method.
   */
  protected function RedirectToController($method=null) {
    $this->RedirectTo($this->request->controller, $method);
  }


  /**
   * Redirect to a controller and method. Uses RedirectTo().
   *
   * @param string controller name the controller or null for current controller.
   * @param string method name the method, default is current method.
   */
  protected function RedirectToControllerMethod($controller=null, $method=null) {
    $controller = is_null($controller) ? $this->request->controller : null;
    $method = is_null($method) ? $this->request->method : null;    
    $this->RedirectTo($this->request->CreateUrl($controller, $method));
   }
 
  

}