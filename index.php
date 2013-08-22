<?php
//
// PHASE: BOOTSTRAP
//
define('MUFFIN_INSTALL_PATH', dirname(__FILE__));
define('MUFFIN_SITE_PATH', MUFFIN_INSTALL_PATH . '/site');

require(MUFFIN_INSTALL_PATH.'/src/CMuffin/bootstrap.php');

$mu = CMuffin::Instance();
//
// PHASE: FRONTCONTROLLER ROUTE
//
$mu->FrontControllerRoute();
//
// PHASE: THEME ENGINE RENDER
//
$mu->ThemeEngineRender();


echo "<h1>I'm MUFFIN - index.php</h1>";
echo "<p>You are most welcome!</p>";
echo "<p>REQUEST_URI - " . htmlentities($_SERVER['REQUEST_URI']) . "</p>";
echo "<p>SCRIPT_NAME - " . htmlentities($_SERVER['SCRIPT_NAME']) . "</p>";