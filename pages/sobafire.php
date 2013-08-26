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
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_SOBAFIRE_TITLE'));
		}

		function Run()
		{
			switch(strtolower($this->site->SanitizeName($_GET['s'])))
			{
				case 'hakkimizda':
					$this->content = Template::Load('sobafire.hakkimizda');
					break;
					
				case 'iletisim':
					$this->content = Template::Load('sobafire.iletisim');
					break;
					
				case 'bagis':
					$this->content = Template::Load('sobafire.bagis');
					break;
					
				case 'api':
					$this->content = Template::Load('sobafire.api');
					break;
					
				case 'nedir':
					$this->content = Template::Load('sobafire.nedir');
					break;
					
				case 'sponsorluk':
					$this->content = Template::Load('sobafire.sponsorluk');
					break;
					
				case 'team':
					$this->content = Template::Load('sobafire.team');
					break;
				
				default:
					$this->content = Template::Load('sobafire');
			}
		}
		
		function Error($error)
		{
			$this->content = Template::Load('error', array('ERROR' => Template::GetLangVar($error)));
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