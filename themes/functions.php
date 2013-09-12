<?php
/**
 * Helpers for theming, available for all themes in their template files and functions.php.
 * This file is included right before the themes own functions.php
 */
 

/**
* Print debuginformation from the framework.
*/
function get_debug() {
  $mu = CMuffin::Instance();  
  $html = null;
  if(isset($mu->config['debug']['db-num-queries']) && $mu->config['debug']['db-num-queries'] && isset($mu->db)) {
    $html .= "<p>Database made " . $mu->db->GetNumQueries() . " queries.</p>";
  }    
  if(isset($mu->config['debug']['db-queries']) && $mu->config['debug']['db-queries'] && isset($mu->db)) {
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $mu->db->GetQueries()) . "</pre>";
  }    
  if(isset($mu->config['debug']['lydia']) && $mu->config['debug']['lydia']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CLydia:</p><pre>" . htmlent(print_r($mu, true)) . "</pre>";
  }    
  return $html;
}

/**
 * Prepend the base_url.
 */
function base_url($url) {
  return CMuffin::Instance()->request->base_url . trim($url, '/');
}


/**
 * Return the current url.
 */
function current_url() {
  return CMuffin::Instance()->request->current_url;
}
