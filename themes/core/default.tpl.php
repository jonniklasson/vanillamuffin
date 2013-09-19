<!doctype html>
<html lang="sv"> 
<head>
  <meta charset="utf-8">
  <title><?=$title?></title>
  <link rel="stylesheet" href="<?=$stylesheet?>">
</head>
<body>
 <div id='wrap-header'>
    <div id='header'>
      <div id='login-menu'>
        <?=login_menu()?>
      </div>
      <div id='banner'>       
        <p class='site-title'><?=$header?></p>
      </div>
    </div>
  </div>
  <div id="main" role="main">
    <?=get_messages_from_session()?>
    <?=@$main?>
	<?=render_views()?>
  </div>
  <div id="footer">
    <?=$footer?>
    <?=get_debug()?>
  </div>
</body>
</html>