<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

	class BasePage
	{
		protected $site, $database, $content, $replace;
		protected $cacheable = TRUE;
		protected $cacheTime = 600;
		protected $type;

		function __construct($site)
		{
			$this->site = $site;
			$this->config = $site->config;
			$this->database = $site->database;
		}


		function _trace_print_var($var)
		{
			if (is_string($var))
				return('\''.str_replace(array("\x00", "\x0a", "\x0d", "\x1a", "\x09"), array('\0', '\n', '\r', '\Z', '\t'), $var).'\'');
			else if (is_int($var))
				return $var;
			else if (is_bool($var))
			{
				if ($var === true) return 'true';
				else return 'false';
			}
			else if (is_array($var))
			{
				$result = 'array(';
				$comma = '';
				foreach ($var as $key => $val)
				{
					$result .= $comma . $this->_trace_print_var($key) . ' => ' . $this->_trace_print_var($val);
					$comma = ', ';
				}
				$result .= ')';
				return $result;
			}
			return var_export($var, true);
		}

		public function __call($name, $arguments)
		{
			if (!method_exists('SiteEngine', $name) || method_exists(__class__, $name))
				return -1337;

			$args = '';
			$comma = '';
			foreach ($arguments as $arg)
			{
				$args .= $comma . $this->_trace_print_var($arg);
				$comma = ', ';
			}

			global $result;
			eval('global $result; $result = $this->site->' . "$name($args);");
			return $result;
		}

		function doError($error)
		{
			$this->content = Template::Load('error', array('errmsg' => Template::GetLangVar($error)));
		}

		function getTemplate()
		{
			return $this->content;
		}
		
		function isCacheable()
		{
			return $this->cacheable;
		}
		
		function getCacheTime()
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