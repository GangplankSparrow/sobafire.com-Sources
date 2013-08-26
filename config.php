<?php

	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

/*
	Veritabanı Ayarları
*/
	
	//Host
	$config['DB']['HOST'] = 'DBHOST';
	
	//Database Adı
	$config['DB']['DBNAME'] = 'DBNAME';
	
	//Database Kullanıcısı
	$config['DB']['USER'] = 'DBUSER';
	
	//Database Şifresi
	$config['DB']['PASS'] = 'DBPASS';

/*
	Site Ayarları
*/
	//Website Adresi
	$config['SITE']['HOST'] = 'http://www.sobafire.com/';
	
	//Title Başlangıcı
	$config['SITE']['TITLE'] = 'Sobafire.com :: ';
	
	//Site Adı
	$config['SITE']['NAME'] = 'Sobafire.com';
	
	//Forum Adresi
	$config['SITE']['FORUM'] = '#'; 

	//FTP Adresi
	$config['SITE']['FTP'] = '#';
	
	//Kayıt olma açıkmı?
	$config['SITE']['REGISTRATION'] = TRUE; 
	
	//Sunucu bakımı açıkmı?
	$config['SITE']['MAINTENANCE'] = FALSE; 
	
	//Debug mesajları gösterilsinmi?
	$config['SITE']['DEBUG'] = TRUE; 
	
	//İletişim Sayfası için E-mail
	$config['SITE']['E_MAIL'] = 'example@example.com';
	
	//Sitenin Google'da çıkması için kelimeler
	$config['SITE']['KEYWORDS'] = 'league of legends, lol, lol builds, lol türkiye, lol türkçe, lol türkçe build, lol türkçe fan sitesi, lol türkçe rehber, league of legends türkçe rehber, league of legends türkçe build, lol türkçe build, lol patch notları, league of legends türkçe patch notları, league of legends Türkçe çeviri, lol Türkçe çeviri';
	
    // Sitenin kısa açıklaması	
	$config['SITE']['DESCRIPTION'] = 'Sobafire.com - Türkiye\'nin ilk ve tek Türkçe build paylaşım platformu.';

?>