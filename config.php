<?php

	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

	/*
	|  Database Settings
	*/
	
	$config['DB']['HOST'] 	= 'DBHOST';
	$config['DB']['DBNAME'] = 'DBNAME';
	$config['DB']['USER'] 	= 'DBUSER';
	$config['DB']['PASS'] 	= 'DBPASS';

	/*
	| Site Settings
	*/
	
	//Domain
	$config['SITE']['HOST'] = 'http://www.sobafire.com/';
	
	//Title prefix
	$config['SITE']['TITLE'] = 'Sobafire.com :: ';
	
	//Site name
	$config['SITE']['NAME'] = 'Sobafire.com';
	
	//Forum address
	$config['SITE']['FORUM'] = '#'; 

	//FTP Address
	$config['SITE']['FTP'] = '#';
	
	//Registration status
	$config['SITE']['REGISTRATION'] = TRUE; 
	
	//Mainteance mode status
	$config['SITE']['MAINTENANCE'] = FALSE; 
	
	//Enable/disable debug messages
	$config['SITE']['DEBUG'] = TRUE; 
	
	//E-mail address for contact forms
	$config['SITE']['E_MAIL'] = 'example@example.com';
	
	//Keywords
	$config['SITE']['KEYWORDS'] = 'league of legends, lol, lol builds, lol türkiye, lol türkçe, lol türkçe build, lol türkçe fan sitesi, lol türkçe rehber, league of legends türkçe rehber, league of legends türkçe build, lol türkçe build, lol patch notları, league of legends türkçe patch notları, league of legends Türkçe çeviri, lol Türkçe çeviri';
	
    	// Description	
	$config['SITE']['DESCRIPTION'] = 'Sobafire.com - Türkiye\'nin ilk ve tek Türkçe build paylaşım platformu.';

?>
