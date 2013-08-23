<?php
/**
* Standard controller layout.
* 
* @package MuffinCore
*/
class CCIndex implements IController {

   /**
    * Implementing interface IController. All controllers must have an index action.
    */
   public function Index() {   
      global $mu;
      $mu->data['title'] = "The Index Controller";
   }

}