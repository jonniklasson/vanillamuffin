<?php
/**
* Helpers for the template file.
*/
$mu->data['header'] = '<h1>Header: Muffin</h1>';
$mu->data['main']   = '<p>Main: Now with a theme engine, Not much more to report for now.</p>';
$mu->data['footer'] = '<p>Footer: &copy; Muffin by Jonathan</p>';


/**
* Print debuginformation from the framework.
*/
function get_debug() {
  $mu = CMuffin::Instance();
  $html = "<h2>Debuginformation</h2><hr><p>The content of the config array:</p><pre>" . htmlentities(print_r($mu->config, true)) . "</pre>";
  $html .= "<hr><p>The content of the data array:</p><pre>" . htmlentities(print_r($mu->data, true)) . "</pre>";
  $html .= "<hr><p>The content of the request array:</p><pre>" . htmlentities(print_r($mu->request, true)) . "</pre>";
  return $html;
}