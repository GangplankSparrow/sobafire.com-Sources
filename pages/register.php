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
		}

		function Run()
		{
			if(isset($_POST['username']))
			{
				$this->Process();
				return;
			}
			else
			{
				$this->Error('Bu sayfaya direkt erişim yasak.');
				return;
			}
		}
		
		function Process()
		{
			$s = $this->site;
			$db = $this->database;
					
			$ip = $_SERVER['REMOTE_ADDR']; 
			$user = $s->SanitizeName(@$_POST['username'], 20);
			$pass1 = $s->SanitizeName(@$_POST['password'], 20);
			$pass2 = $s->SanitizeName(@$_POST['cpassword'], 20);
			$email1 = $s->SanitizeEmail(@$_POST['email'], 254);
			$email2 = $s->SanitizeEmail(@$_POST['cemail'], 254);
			$realname = 'aristona silindi';
			$realsirname = 'aristona silindi';
			
			if (strlen(@$_POST['username']) > 20 || strlen($user) < 4)
			{
				$this->Error('Kullanıcı adı uzunluğu 4 ile 20 karakter arasında olmalıdır.');
				return;
			}
			
			if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['username']))
			{
				$this->Error('Kullanıcı adı tanımlanamayan karakterler barındırıyor. Lütfen Türkçe yada Unicode karakterler kullanmayınız.');
				return;
			}
			
			if (strlen($pass1) > 20 || strlen($pass1) <= 8)
			{
				$this->Error('Şifre uzunluğu 8 ile 20 karakter arasında olmalıdır.');
				return;
			}
			
			if ($pass1 != $pass2)
			{
				$this->Error('Girmiş olduğunuz şifreler birbirine uymuyor.');
				return;
			}
		
			if (strlen($email1) > 50 || strlen($email1) <= 5)
			{
				$this->Error('Email uzunluğu 5 ile 50 karakter arasında olmalıdır.');
				return;
			}
			
			if (!preg_match("/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i", $email1))
			{
				$this->Error('Girmiş olduğunuz e-mail doğru görünmüyor.');
				return;
			}
			
			if ($email1 != $email2)
			{
				$this->Error('Girmiş olduğunuz emailler birbirine uyuşmuyor.');
				return;
			}
			
			$num_rows = $db->doQuery('SELECT Username FROM USERDATA WHERE Username = ?', $user);
			if ($num_rows == -1)
			{
				$this->Error('Veritabanı hatası. Bu hata kaydedildi.');
				$db->getError();
				return;
			}
			elseif ($num_rows > 0)
			{
				$this->Error('Kullanıcı adı kullanımda! Lütfen farklı bir kullanıcı adı seçiniz.');
				return;
			} 
			
			$num_rows = $db->doQuery('SELECT Email FROM USERDATA WHERE Email = ?', $email1);
			if ($num_rows == -1)
			{
				$this->Error('Veritabanı hatası. Bu hata kaydedildi.');
				$db->getError();
				return;
			}
			elseif ($num_rows > 0)
			{
				$this->Error('Email kullanımda! Lütfen farklı bir email seçiniz.');
				return;
			}
			
			
			$num_rows = $db->doQuery('INSERT INTO USERDATA (Username, Password, Email, Realname, Realsirname, Yetki) VALUES(?, ?, ?, ?, ?, ?)', $user, $pass1, $email1, $realname, $realsirname, 1);
			if ($num_rows == -1)
			{
				$this->Error('Veritabanı hatası. Bu hata kaydedildi.');
				$db->getError();
				return;
			}

			$response = array();
			$response['status'] = 'success';
			$response['username'] = $user;
			
			$this->content = json_encode($response);
		}
		
		function Error($error)
		{
			$response['status'] = 'error';
			$response['error_message'] = $error;
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