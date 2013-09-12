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
  if(empty($mu->config['debug'])) {
   return;
  }
  
  $html = null;
  if(isset($mu->config['debug']['db-num-queries']) && $mu->config['debug']['db-num-queries'] && isset($mu->db)) {
    $flash = $mu->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;	
	$html .= "<p>Database made $flash" . $mu->db->GetNumQueries() . " queries.</p>";
  }    
  if(isset($mu->config['debug']['db-queries']) && $mu->config['debug']['db-queries'] && isset($mu->db)) {
    $flash = $mu->session->GetFlash('database_queries');
    $queries = $mu->db->GetQueries();
    if($flash) {
      $queries = array_merge($flash, $queries);
    }   
   $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
  }    
 if(isset($mu->config['debug']['timer']) && $mu->config['debug']['timer']) {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $mu->timer['first'], 5)*1000 . " msecs.</p>";
  }    
  if(isset($mu->config['debug']['muffin']) && $mu->config['debug']['muffin']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CMuffin:</p><pre>" . htmlent(print_r($mu, true)) . "</pre>";
  }    
  if(isset($mu->config['debug']['session']) && $mu->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>The content of Cmuffin->session:</p><pre>" . htmlent(print_r($mu->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  }    
  return $html;
}

/**
 * Prepend the base_url.
 */
function base_url($url=null) {
  return CMuffin::Instance()->request->base_url . trim($url, '/');
}

/**
 * Create a url to an internal resource.
 */
function create_url($url=null) {
  return CMuffin::Instance()->request->CreateUrl($url);
}

/**
 * Prepend the theme_url, which is the url to the current theme directory.
 */
function theme_url($url) {
  $mu = CMuffin::Instance();
  return "{$mu->request->base_url}themes/{$mu->config['theme']['name']}/{$url}";
}






/**
* Get messages stored in flash-session.
*/
function get_messages_from_session() {
  $messages = CMuffin::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}

/**
 * Return the current url.
 */
function current_url() {
  return CMuffin::Instance()->request->current_url;
}

/**
* Render all views.
*/

function render_views() {
  return CMuffin::Instance()->views->Render();
}