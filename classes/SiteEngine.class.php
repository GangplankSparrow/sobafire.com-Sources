<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

	require_once('Template.class.php');
	require_once('BasePage.class.php');
	require_once('Database.class.php');
	require_once('ImageUpload.class.php');
	require_once('Misc.class.php');
	require_once('BBCode.class.php');

	define('SANITIZE_UNKNOWN', 0);
	define('SANITIZE_SMALL_TEXT', 1);
	define('SANITIZE_EMAIL', 2);
	define('SANITIZE_LONG_TEXT', 3);
	define('SANITIZE_INTEGER', 4);
	
  class SiteEngine
	{ 
		public $database, $config, $language = 'en', $loggedIn = false;
		
		function __construct($config)
		{
			$this->database = new Database(@$config['DB']['HOST'], @$config['DB']['DBNAME'], @$config['DB']['USER'], @$config['DB']['PASS']);
			$this->imageupload = new SimpleImage();
			$this->misc = new Misc();
			$this->bbcode = new BBCode($this); //$this bu classa bağlanıyor.

			$this->config = $config;

			if (@get_magic_quotes_gpc()) 
			{
				 foreach($_GET as $k => $v)
				   $_GET[$k] = stripslashes($v);
				   
				 foreach ($_POST as $k => $v)
					$_POST[$k] = stripslashes($v);
			}
      
			ini_set('magic_quotes_runtime', 0); //deprecated as of 5.3, completely removed on 6.0 (' => \')
			ini_set('magic_quotes_sybase', 0); //deprecated as of 5.3
			
			Template::SetLanguage();
		}
		
		function Initialize($pages)
		{
			$act = @$_GET['page'];
			if (empty($act)) $act = @$_GET['p'];
			$default = FALSE;
			
			if (!isset($_GET['page']) && !isset($_GET['p']))
			{
				$act = reset($pages);
				$default = TRUE;	
			}
			else
			{
				if (!property_exists((object)$pages, $act))
				{
					$act = reset($pages);
					$default = TRUE;
				}
				else
				{     
					$act = $pages[$act];
				}
			}
			
			if (!file_exists($act))
			{
				$act = reset($pages);
				$default = TRUE;
			}

			if ($default == TRUE)
			{
				Template::SetPage('main');
				$_SERVER['QUERY_STRING'] = NULL;
			}
	
			if ($this->LoggedIn())
			{
				Template::SetVar('login', '<@login-in@>');
				Template::SetVar('Username', $_SESSION['Username']);
				Template::SetVar('Password', $_SESSION['Password']);
				Template::SetVar('Email', $_SESSION['Email']);
				Template::SetVar('SecretID', $_SESSION['SecretID']);
				Template::SetVar('Referrer', $_SESSION['Referrer']);
				Template::SetVar('Yetki', $_SESSION['Yetki']);
				Template::SetVar('TextYetki', $this->getPermission($_SESSION['Yetki']));
				Template::SetVar('Account_Menu', '<li><a href="' . $this->config['SITE']['HOST'] . '#!profilim.html">Profilim</a></li>');
				Template::SetVar('LOGIN_USERNAME', '<a style="color: #ECB524" href="#" id="switchLogoutModal">' . $_SESSION['Username'] . ' (Çıkış yap)</a>');
			}
			else
			{
				Template::SetVar('login', '<@login-out@>');
				Template::SetVar('Username', NULL);
				Template::SetVar('Password', NULL);
				Template::SetVar('Email', NULL);
				Template::SetVar('SecretID', NULL);
				Template::SetVar('Referrer', NULL);
				Template::SetVar('Yetki', NULL);
				Template::SetVar('TextYetki', NULL);
				Template::SetVar('Account_Menu', null);
				Template::SetVar('LOGIN_USERNAME', '<a style="color: #ECB524" href="#" id="switchLoginModal">(Giriş yapılmamış)</a>');
			}
							
			Template::SetVar('server', $this->config['SITE']['NAME']);
			Template::SetVar('forum', $this->config['SITE']['FORUM']);
			Template::SetVar('description', $this->config['SITE']['DESCRIPTION']);
			Template::SetVar('keywords', $this->config['SITE']['KEYWORDS']);
			Template::SetVar('SITE_ADDR', $this->config['SITE']['HOST']);
			Template::SetVar('BG_ID', rand(1,3));
			
			
			Template::SetVar('HISTORY_NEWS_AREA', $this->getNewsCommentHistory());
			Template::SetVar('HISTORY_BUILD_AREA', $this->getBuildCommentHistory());

			require_once($act);
			$page = new Page($this);

			if($page->GetType() == 'JSON')
			{
				header("Content-type: application/json");
				$page->Run();
				$content = $page->GetTemplate();
				echo $content;
			}
			else
			{
				if ($page->IsCacheable())
				{
					$cachefile = './cache/' . basename($act) . '-' . $this->language . '_';
					if ($_SERVER['QUERY_STRING'] != '')
						$cachefile .= base64_encode($_SERVER['QUERY_STRING']);
						
					if (!file_exists($cachefile))
					{
						$page->Run();
						$content = $page->GetTemplate();
						Template::SetVar('CACHESTATUS', Template::GetLangVar('CACHE_CREATING'));
						if ($page->IsCacheable())
						{
							$fp = fopen($cachefile, 'w');
							fwrite($fp, $content);
							fclose($fp);
						}
					}
					else if ((time() - $page->CacheTime()) <= filemtime($cachefile))
					{
						Template::SetVar('CACHESTATUS', Template::GetLangVar('CACHE_READING'));
						$fp = fopen($cachefile, 'r');
						$content = fread($fp, filesize($cachefile));
						fclose($fp);
					}
					else
					{
						$page->Run();
						$content = $page->GetTemplate();
						Template::SetVar('CACHESTATUS', Template::GetLangVar('CACHE_RECREATING'));
						if ($page->IsCacheable())
						{
							$fp = fopen($cachefile, 'w');
							fwrite($fp, $content);
							fclose($fp);
						}
					}
				}
				else
				{
					Template::SetVar('CACHESTATUS', Template::GetLangVar('CACHE_DISABLED'));
					$page->Run();
					$content = $page->GetTemplate();
				}
				
				if (is_null($this->database->amountQueries()))
				{
					Template::SetVar('amountqueries', 0);
				}
				else
				{
					Template::SetVar('amountqueries', $this->database->amountQueries());
				}
		  
				Template::SetVar('content', $content);
				Template::BuildPage();
			}
		}

		function LoggedIn()
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{			
				$this->loggedIn = false;
				return FALSE;
			}

			if ($_SESSION['IP'] != $this->GetRemoteIP())
			{
				$this->loggedIn = false;
				$this->doLogout();
				return FALSE;
			}

			$db = $this->database;
			$num_rows = $db->doQuery('SELECT Username, Password FROM USERDATA Where Username = ?', $_SESSION['Username']);
				
			if ($num_rows <= 0)
			{
				$loggedIn = false;
				$this->doLogout();
				return FALSE;
			}
			$row = $db->doRead();
			if ($_SESSION['Password'] != $row['Password'])
			{
				$this->loggedIn = false;
				$this->doLogout();
				return FALSE;
			}	
		  	$this->loggedIn = true;
			return TRUE;
		}
		
   	    function doLogout()
		{
			foreach ($_SESSION as $k => $v)
			unset($_SESSION[$k]);
			session_destroy();
		}
	
		function GetRemoteIP()
		{
			return isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
		}	
		
		function pageLoadTime()
		{
			$time = explode( " ", microtime());
			$usec = (double)$time[0];
			$sec = (double)$time[1];
			return $sec + $usec;
		}
		
		function getNewsCommentHistory()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('SELECT LOL_HABER_COMMENTS.yorum, LOL_HABER_COMMENTS.yorumcu, LOL_HABER_COMMENTS.haber_id, LOL_HABER.baslik, LOL_HABER.sef FROM LOL_HABER_COMMENTS
									  INNER JOIN LOL_HABER
									  ON LOL_HABER_COMMENTS.haber_id=LOL_HABER.id
									  ORDER BY LOL_HABER_COMMENTS.haber_id DESC LIMIT 0,3');
			$content = NULL;
			while ($row = $db->doRead())
			{
				$content .= Template::Load('right_content.historyarea.news.part', array('YORUMCU' => $row['yorumcu'], 'YORUM' => $row['yorum'], 'HABER_ID' => $row['haber_id'], 'BASLIK' => $row['baslik'], 'SEF' => $row['sef']));
			}
			return $content;
		}
		
		function getBuildCommentHistory()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('SELECT LOL_BUILD_COMMENTS.yorum, LOL_BUILD_COMMENTS.yorumcu, LOL_BUILD_COMMENTS.build_id, LOL_BUILDS.buildName, LOL_BUILDS.sefLink FROM LOL_BUILD_COMMENTS
									  INNER JOIN LOL_BUILDS
									  ON LOL_BUILD_COMMENTS.build_id=LOL_BUILDS.id
									  ORDER BY LOL_BUILD_COMMENTS.build_id DESC LIMIT 0,3');
			$content = NULL;
			while ($row = $db->doRead())
			{
				$content .= Template::Load('right_content.historyarea.build.part', array('YORUMCU' => $row['yorumcu'], 'YORUM' => $row['yorum'], 'BUILD_ID' => $row['build_id'], 'BUILD_NAME' => $row['buildName'], 'SEF' => $row['sefLink']));
			}
			return $content;
		}
    
		function getPermission($yetki)
		{
			switch(intval($yetki))
			{
            case 0:
              return Template::GetLangVar('ADMIN');
              break;
              
            case 1:
              return Template::GetLangVar('USER');
              break;
            
            case 255:
              return Template::GetLangVar('BANNED');
              break;
              
            default:
              return NULL;
			}
		}
		
		function Error($error)
		{
			$this->content = Template::Load('error', array('ERROR' => Template::GetLangVar($error)));
		}

		function SanitizeName($in, $len = 20)
		{
			return substr(preg_replace("/[^a-zA-Z0-9_]/", "", htmlspecialchars(htmlentities(strip_tags($in)))), 0, $len);
		}
		
		function SanitizeText($in, $len)
		{
			return substr(preg_replace("/[^a-zA-Z0-9.+\\^!#$=`~\[\]\{\};:%&*\(\)@_-]/", "", htmlspecialchars(htmlentities(strip_tags($in)))), 0, $len);
		}
		
		function SanitizeEmail($in, $len = 60)
		{
			return substr(preg_replace("/[^a-zA-Z0-9.+@_-]/", "", htmlspecialchars(htmlentities(strip_tags($in)))), 0, $len);
		}
		
		function __destruct()
		{
		}
	}
		
?>