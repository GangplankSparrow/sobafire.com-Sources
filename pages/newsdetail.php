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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_NEWS_TITLE'));
		}

		function Run()
		{
			if(!isset($_GET['newID']))
			{
				$this->basicError('Haber bulunamadı.');
				return;
			}
			
			$newID = intval($_GET['newID']);
			
			if($newID < 1)
			{
				$this->basicError('Haber numarası eksi bir rakam olamaz.');
				return;
			}
			
			//haber bilgisini çek
			$num_rows = $this->database->doQuery('SELECT * FROM LOL_HABER WHERE id = ? ORDER BY id DESC', $newID);
			if($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			else if($num_rows == 0)
			{
				$this->basicError('Bu haber veritabanında bulunamadı.');
				return;
			}
			
			$row = $this->database->doRead();
			$news = Template::Load('newsdetail.part', array('HABER_ID' => $row['id'], 'HABER_TARIH' => $row['tarih'], 'HABER_BASLIK' => $row['baslik'], 'HABER_ICERIK' => $row['icerik'], 'HABER_YAZAR' => $row['yazar'], 'HABER_IMG' => $row['img'], 'HABER_READCOUNT' => $row['readcount']));
			Template::SetVar('HABER_HABERALANI', $news);
			//Title
			Template::SetVar('title', $this->config['SITE']['TITLE'] . $row['baslik']);
			
			//yorum bilgisini çek
			$this->database->doQuery('SELECT * FROM LOL_HABER_COMMENTS WHERE haber_id = ?', $newID);
			$yorumlar = null;
			while($row = $this->database->doRead())
			{
				$yorumlar .= Template::Load('newsdetail.comments', array('YORUM_ID' => $row['id'], 'YORUM_TARIH' => $row['tarih'], 'YORUM_ICERIK' => $row['yorum'], 'YORUM_YORUMCU' => $row['yorumcu']));
			}
			
			Template::SetVar('HABER_YORUMLAR', $yorumlar);
			
		
			//eğer login olunmuşsa yorum yapma ekranını göster
			Template::SetVar('HABER_YORUMEKLE', $this->showCommentingForm());
			Template::SetVar('HABER_FIXED_ID', $newID);
			
			//Okunma sayısını 1 artır.
			$this->database->doQuery('UPDATE LOL_HABER SET readcount = readcount + 1 WHERE id = ?', $newID);
			
			//--Update Comet History
			if (isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == TRUE) 
			{
				$this->site->misc->addCometHistory($_SESSION['Username'] . ', haberleri okuyor.');
			}
			else
			{
				$this->site->misc->addCometHistory($this->site->GetRemoteIP() . ', haberleri okuyor.');
			}
			
			
			$this->content = Template::Load('newsdetail');
			
		}
		
		function showCommentingForm()
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{
				return Template::Load('info', array('ERROR' => 'Yorum yapabilmek için önce giriş yapmanız gerekiyor.'));
			}
			else
			{
				return Template::Load('newsdetail.addcomment');
			}
		}
		
		function basicError($error)
		{
			$this->content = Template::Load('error', array('error' => $error));
		}
		
		function Error($error)
		{
			$this->content = Template::Load('error', array('error' => Template::GetLangVar($error)));
		}
		
		function Success($error)
		{
			$this->content = Template::Load('success', array('error' => $error));
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