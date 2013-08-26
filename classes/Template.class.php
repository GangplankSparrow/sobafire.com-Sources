<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();
	
	//linuxta /themes/ -- windowsta \\themes\\
	define('INTERNAL_THEMES_DIR', getcwd() . '/themes/');
	define('EXTERNAL_THEMES_DIR', './themes/');

	class Template
	{
		public static $pageVars;
		public static $theme = 'default';
		public static $language;
		public static $mainPage = 'page';
		public static $noCache = FALSE;
		public static $hooks = array();
		public static $noShow = FALSE;

		static function noShow() 
		{ 
			self::$noShow = TRUE; 
		}  

		static function doDisableCache()
		{
			self::$noCache = TRUE;
		}

		static function isNoCache()
		{
			return self::$noCache;
		}

		static function AddHook($page, $newPage)
		{
			self::$hooks[strtolower($page)] = $newPage;
		}

		static function SetTheme($theme)
		{
			self::$theme = $theme;
		}
		
		static function SetLanguage()
		{
			@$langvar = $_COOKIE["Language"];
			switch($langvar)
			{
				case 1:
				     $lang = 'en';
					 break;
					 
			    case 2:
				     $lang = 'tr';
					 break;
					 
			    default:
				      $lang = 'tr';
			}
			
			require_once('./language/' . $lang . '.lang.php');
			self::$language = $language;
		}
		
		static function SetPage($page)
		{
			self::$mainPage = $page;
		}
		

		static function SetVar($key, $value)
		{
			self::$pageVars[$key] = self::EvaluateIncludes($value);
		}
		
		static function GetVar($key)
		{
			return @self::$pageVars[$key];
		}
		
		static function Resize($imageurl)
		{
			return @self::$pageVars[$key];
		}
		
		static function EvaluateIncludes($input)
		{
			return preg_replace_callback("/<@(.*)@>/", create_function('$matches', 'return Template::Load(strtolower($matches[1]));'), $input);
		}

		static function EvaluateLangVars($input)
		{
			return preg_replace_callback("/<:(.*):>/", create_function('$matches', 'return Template::GetLangVar(strtoupper($matches[1]));'), $input);
		}
		
		static function GetLangVar($key, $data = NULL)
		{
			$string = self::$language[$key];
			
			if (is_array($data))
				$string = Template::Evaluate($string, $data);
				
			return $string;
		}
		
		static function Evaluate($result, $replace = NULL)
		{
			$result = self::EvaluateIncludes($result);

			if (is_array(self::$pageVars))
			{
				foreach (self::$pageVars as $k => $v)
					$result = str_ireplace('<%' . $k . '%>', $v, $result);
			}
			
			if (is_array($replace))
			{
				foreach ($replace as $k => $v)
					$result = str_ireplace('<%' . $k . '%>', $v, $result);
			}

			return self::EvaluateLangVars($result);
		}
		
		static function Load($page, $replace = NULL)
		{
			if (isset(self::$hooks[$page]))
			{
				$page = strtolower(self::$hooks[$page]);
			}

			$result = '';
			$fn = file_exists(INTERNAL_THEMES_DIR . self::$theme . '/' . $page . '.tpl') ? INTERNAL_THEMES_DIR . self::$theme . '/' . $page . '.tpl' : INTERNAL_THEMES_DIR . self::$theme . '/' . '404' . '.tpl';
			$fh = @fopen($fn, 'r');
			$result = @fread($fh, filesize($fn));
			@fclose($fh);
				
			return self::Evaluate($result, $replace);
		}
		
		function setAjaxStatus()
		{
		  (@$_GET['module'] != 'ajax') ? self::disableAjax() : self::enableAjax();
		}
		
		function enableAjax()
		{
			echo self::Load('ajax');
		}
		
		function disableAjax()
		{
			echo self::Load(self::$mainPage);
		}
	
		static function BuildPage()
		{
		if (self::$noShow)
        return;
			self::SetVar('theme', EXTERNAL_THEMES_DIR . self::$theme . '/');
			self::setAjaxStatus();
		}
	}

?>