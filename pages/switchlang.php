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
			
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_SWITCHLANG_TITLE'));
			$this->site->Pagination('PAGE_SWITCHLANG_TITLE');
		}

		function Run()
		{
			switch (@$_GET['act'])
			{
				case 'en':
					$this->toEnglish();
					break;
					
				case 'tr':
					$this->toTurkish();
					break;
					
				default:
					$this->toTurkish();
			}
		}
		
		function toEnglish()
		{
			setcookie("Language", 1);
			Template::SetVar('redir', NULL);
			$this->content = Template::Load('redirect');
		}
		
		function toTurkish()
		{
			setcookie("Language", 2);
			Template::SetVar('redir', NULL);
			$this->content = Template::Load('redirect');
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