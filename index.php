<?php

	define('ARISTONA', 1);
	define('CLASS_DIR', './classes/');
	define('SCRIPT_DIR', './pages/');
	define('POPUP_DIR', './pages/popups/');

	require_once('config.php');
	require_once(CLASS_DIR . 'SiteEngine.class.php');
	session_start();
	$site = new SiteEngine($config);
	$saymaya_basla = $site->pageLoadTime();

	$pages = array
	(
		'main'			=>	SCRIPT_DIR . 'main.php',
		'login'			=>	SCRIPT_DIR . 'login.php',
		'logout'		=>	SCRIPT_DIR . 'logout.php',
		'register'		=>	SCRIPT_DIR . 'register.php',
		'switchlang'		=>	SCRIPT_DIR . 'switchlang.php',
		'account'		=>	SCRIPT_DIR . 'account.php',
		'contact'		=>	SCRIPT_DIR . 'contact.php',
		'admin'			=>	SCRIPT_DIR . 'admin.php',
		'build'			=>	SCRIPT_DIR . 'build.php',
		'sobafire'		=>	SCRIPT_DIR . 'sobafire.php',
		'ajax'			=>	SCRIPT_DIR . 'ajax.php',
		'browsebuilds'		=>	SCRIPT_DIR . 'browsebuilds.php',
		'browsevideos'		=>	SCRIPT_DIR . 'browsevideos.php',
		'browseusers'		=>	SCRIPT_DIR . 'browseusers.php',
		'browseteams'		=>	SCRIPT_DIR . 'browseteams.php',
		'viewprofile'		=>	SCRIPT_DIR . 'viewprofile.php',
		'newsdetail'		=>	SCRIPT_DIR . 'newsdetail.php',
		'tournament'		=>	SCRIPT_DIR . 'tournament.php',

	);
	
	$site->Initialize($pages);

	$saymayi_bitir = $site->pageLoadTime(); 
	$basla = $saymayi_bitir - $saymaya_basla; 
	$sonuc = substr($basla, 0, 5);
	Template::SetVar('PAGELOADTIME', $sonuc . ' sn');
?>

