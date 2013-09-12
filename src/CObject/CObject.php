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

   /**
    * Constructor
    */
   protected function __construct() {
    $mu = CMuffin::Instance();
    $this->config   = &$mu->config;
    $this->request  = &$mu->request;
    $this->data     = &$mu->data;
	$this->db       = &$mu->db;
  }

}