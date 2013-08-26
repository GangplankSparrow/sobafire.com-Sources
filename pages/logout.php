<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

	class Page
	{
		private $site, $database, $content, $replace;
		private $cacheable = FALSE;
		private $cacheTime = 0;
		private $type = 'HTML';
		
		function __construct($site)
		{
			$this->site = $site;
			$this->config = $site->config;
			$this->database = $site->database;
			
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_REGISTER_TITLE'));
		}
		
		function Run()
		{
			if(!isset($_SESSION['Username']))
			{
				$this->Error('Giriş yapmamışsın ki?');
				return;
			}
			
			$this->site->doLogout();
			$this->Success('Çıkış başarılı.');
		}
		
		function Error($error)
		{
			Template::SetVar('error', $error);
			$this->content = Template::Load('error');
		}
		
		function Success($error)
		{
			Template::SetVar('error', $error);
			$this->content = Template::Load('success');
		}
		
		function GetTemplate()
		{
			return $this->content;
		}
		
		function IsCacheable()
		{
			return $this->cacheable;
		}
		
		function CacheTime()
		{
			return $this->cacheTime;
		}
		
		function GetType()
		{
			return $this->type;
		}
		
		function __destruct()
		{
		}
	}
	
?>