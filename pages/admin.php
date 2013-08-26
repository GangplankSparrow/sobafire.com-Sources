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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_ADMIN_TITLE'));
		}

		function Run()
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{
				$this->content = Template::Load('error', array('error' => Template::GetLangVar('LOGIN_REQUIRED')));
				return;
			}
			
			if (!isset($_SESSION['Yetki']) || $_SESSION['Yetki'] != 0)
			{
				$this->content = Template::Load('error', array('error' => Template::GetLangVar('ADMIN_PERMISSION_REQUIRED')));
				return;
			}
			
			switch (@$this->site->SanitizeName($_GET['s']))
			{
				case 'user':
				$this->User();
				break;
							
				case 'addprojects':
				$this->AddProjects();
				break;
				
				case 'deleteprojects':
				$this->DeleteProjects();
				break;
			
				case 'addnews':
				$this->AddNews();
				break;
				
				case 'deletenews':
				$this->DeleteNews();
				break;
				
				case 'slider':
			  $this->Slider();
				break;
					
				default:
				$this->ShowMain();
			}
		}
		
		//user
		
		function User()
		{
			 !isset($_POST['submit']) ? $this->ShowForm() : $this->User_Process();
		}
		
		function User_Process()
		{
		  $username = $this->site->SanitizeName($_POST['username']);
		  $option = intval($_POST['option']);
		  
		  if ($option != 0 || $option != 1 || $option != 255)
		  {
				$this->Error('ADMIN_USER_OPTION_WRONG');
		  }
		  
		  $db = $this->database;
		  $num_rows = $db->doQuery('SELECT * FROM USERDATA Where Username = ?', $username);
		  if ($num_rows == -1)
		  {
			  $this->Error('DB_ERROR');
			  $db->getError();
			  return;
		  }
		  if ($num_rows == 0)
		  {
			  $this->Error('ADMIN_USER_NOT_FOUND');
			  return;
		  }
		 
		  $db = $this->database;
		  $num_rows = $db->doQuery('UPDATE USERDATA Set Yetki = ? WHERE Username = ?', $option, $username);
		  $this->Error('PROCESS_COMPLETE');
		}
		
		//AddNews
		
		function AddNews()
		{
			 !isset($_POST['submit']) ? $this->ShowForm() : $this->AddNews_Process();
		}
		
		function AddNews_Process()
		{
		  $baslik = $_POST['baslik'];
		  $konu = nl2br($_POST['konu']);
		  
		  if(strlen($baslik) > 30 || strlen($baslik) == NULL)
		  {
			  $this->Error('ADMIN_NEWS_HEADER_TOO_LONG');
			  return;
		  }
		  
		  else if(strlen($konu) > 1000 || strlen($konu) == NULL)
		  {
			  $this->Error('ADMIN_NEWS_SUBJECT_TOO_LONG');
			  return;
		  }
		  else
		  {
			  $db = $this->database;
			  $num_rows = $db->doQuery('INSERT INTO HABERLER (Baslik, Konu, Tarih) VALUES (?, ?, ?)', $baslik, $konu, date("d.m.Y"));
			  $this->Error('PROCESS_COMPLETE');
		  }
		  
		}
		
		//DeleteNews
		function DeleteNews()
		{
			 !isset($_POST['submit']) ? $this->ShowForm() : $this->DeleteNews_Process();
		}
		
		function DeleteNews_Process()
		{
		  $id = intval($_POST['id']);
		  
		  $db = $this->database;
		  $num_rows = $db->doQuery('DELETE FROM HABERLER WHERE id = ?', $id);
		  if ($num_rows == -1)
		  {
			  $this->Error('DB_ERROR');
			  $db->getError();
			  return;
		  }
		  
		  $this->Error('PROCESS_COMPLETE');
		  
		}
		
		//DeleteNews
		function DeleteProjects()
		{
			!isset($_POST['submit']) ? $this->ShowForm() : $this->DeleteProjects_Process();
		}
		
		function DeleteProjects_Process()
		{
		  $id = intval($_POST['id']);
		  
		  $db = $this->database;
		  $num_rows = $db->doQuery('DELETE FROM PROJELER_2 WHERE id = ?', $id);
		  if ($num_rows == -1)
		  {
			  $this->Error('DB_ERROR');
			  $db->getError();
			  return;
		  }
		  
		  $this->Error('PROCESS_COMPLETE');
		  
		}
		
		//Slider
		function Slider()
		{
			 !isset($_POST['submit']) ? $this->ShowForm() : $this->Slider_Process();
		}
		
		function Slider_Process()
		{
		}
		
		function ShowForm()
		{
			$this->content = Template::Load('admin', array('HATA' => NULL));
		}
		
		function getRandomName()
		{
			return strtolower(substr(md5(rand(0, 9999999999)), 0, 10));
		}
	
		function ShowMain()
		{
			$this->content = Template::Load('admin', array('HATA' => NULL));
		}
		
		function Error($error)
		{
			$this->content = Template::Load('admin', array('HATA' => Template::GetLangVar($error)));
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