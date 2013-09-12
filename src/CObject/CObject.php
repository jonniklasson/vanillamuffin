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
	protected function RedirectTo($url) {
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
    header('Location: ' . $this->request->CreateUrl($url));
  }

  

}