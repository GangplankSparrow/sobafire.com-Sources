<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

	class Page
	{
		private $site, $database, $content, $replace;
		private $cacheable = FALSE;
		private $cacheTime = 0;
		private $type = 'JSON';
		
		function __construct($site)
		{
			$this->site = $site;
			$this->config = $site->config;
			$this->database = $site->database;
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_LOGIN_TITLE'));
		}

		function Run()
		{
			if(isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == TRUE) 
			{
				$this->Error('ERROR_LOGIN_ALREADY_LOGGED');
				return;
			}
			else if(!isset($_POST['username'])) 
			{
				return;
			}
			else 
			{
				$this->handleLogin();
			}
		}
    
		function handleLogin()
		{		
			
			$user = $this->site->SanitizeName($_POST['username'], 20);
			$pass = $this->site->SanitizeName($_POST['password'], 20);
			
			$db = $this->database;
			$num_rows = $db->doQuery('SELECT Username, Password, Email, Realname, Realsirname, Yetki FROM USERDATA WHERE Username = ?', $user);
			if ($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			else if ($num_rows == 0)
			{
				$this->Error('ERROR_LOGIN_FAILED');
				return;
			}
			$row = $db->doRead();
			
			if ($pass != $row['Password'])
			{
				$this->Error('ERROR_LOGIN_FAILED');
				return;
			}
			
			$_SESSION['bLoggedIn'] = TRUE;
			$_SESSION['Username'] = $row['Username'];
			$_SESSION['Password'] = $row['Password'];
			$_SESSION['Email'] = $row['Email'];
			$_SESSION['Realname'] = $row['Realname'];
			$_SESSION['IP'] = $this->site->GetRemoteIP();
			$_SESSION['Realsirname'] = $row['Realsirname'];
			$_SESSION['Yetki'] = $row['Yetki'];
			$_SESSION['TextYetki'] = $this->site->getPermission($row['Yetki']);
			
			$response = array();
			$response['status'] = 'success';
			$response['username'] = $user;
			
			$this->content = json_encode($response);
			
		}
		
		function Error($error)
		{
			$response['status'] = 'error';
			$response['error_message'] = Template::GetLangVar($error);
			$this->content = json_encode($response);
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