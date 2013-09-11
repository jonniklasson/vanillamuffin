<?php
// PHASE: BOOTSTRAP
define('MUFFIN_INSTALL_PATH', dirname(__FILE__));
define('MUFFIN_SITE_PATH', MUFFIN_INSTALL_PATH . '/site');

require(MUFFIN_INSTALL_PATH.'/src/bootstrap.php');

$mu = CMuffin::Instance();
//
// PHASE: FRONTCONTROLLER ROUTE
//
$mu->FrontControllerRoute();
//
// PHASE: THEME ENGINE RENDER
//
$mu->ThemeEngineRender();

