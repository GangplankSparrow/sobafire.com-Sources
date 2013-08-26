<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();
		
	define('SKILLS_DIR', 'http://www.sobafire.com/themes/default/images/lol/abilities/');
	define('RUNES_DIR', 'http://www.sobafire.com/themes/default/images/lol/runes/');
	define('SUMMONERS_DIR', 'http://www.sobafire.com/themes/default/images/lol/summoners/');
	define('ITEMS_DIR', 'http://www.sobafire.com/themes/default/images/lol/items/');
	define('MASTERIES_DIR', 'http://www.sobafire.com/themes/default/images/lol/masteries/');
		
	class Page
	{
		private $site, $database, $content;
		private $cacheable = FALSE;
		private $cacheTime = 600;
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
			Template::SetPage('page.ajax'); //default olarak page.tpl yerine page.ajax.tpl kullanıyoruz
			
			if(isset($_GET['attachment']))
			{
				$this->content = Template::Load('error', array('ERROR' => 'Maç sonucu bulunamadı.'));
				return;
			}
			else if(!isset($_POST['c0']))
			{
				if(isset($_GET['ajaxType']))
				{
					$type = $this->site->SanitizeName($_GET['ajaxType']);
					
					if($type == 'ITEM')
					{
						$itemID = intval($_GET['itemID']);
						$this->site->database->doQuery('SELECT * FROM LOL_ITEMS WHERE item_id = ?', $itemID);
						$row = $this->site->database->doRead();
						$content = '<img src="' . ITEMS_DIR . $row['item_id'] . '.png">';
					}
					else
					{
						$content = "Ajax hatası";
					}
				}
				else
				{
					$content = "İtem yokki";
				}
			}
			else
			{
				$safec0 = $this->site->SanitizeName($_POST['c0']);
				$safec1 = $this->site->SanitizeName($_POST['c1']);
				$pieces = explode("_", $safec1);
		
				if($pieces[0] == 'skills')
				{
					$this->site->database->doQuery('SELECT * FROM LOL_SKILLS WHERE SkillNum = ?', $pieces[1]);
					$row = $this->site->database->doRead();
			
					if(strlen(trim($row['TR'])) >= 1)
					{
						$content = '<img src="' . SKILLS_DIR . $row['imgPath'] . '" alt="' . $row['TR_skillname'] . '"><br><font color="orange">' . $row['TR_skillname'] . '</font><br><br>' . $row['TR'] . '<br><br><font color="#519271">Çevirmen: ' . $row['Cevirmen'] . '</font>';
					}
					else
					{
						$content = '<img src="' . SKILLS_DIR . $row['imgPath'] . '" alt="' . $row['TR_skillname'] . '"><br><font color="orange">' . $row['EN_skillname'] . '</font><br><br>' . $row['EN'];
					}
		
				}
				else if($pieces[0] == 'runes')
				{
					$this->site->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $pieces[1]);
					$row = $this->site->database->doRead();
					$content = '<img src="' . RUNES_DIR . $row['rune_image'] . '.png"><br><font color="orange">' . $row['rune_name'] . '</font><br><br>' . $row['rune_icerik'];
				}
				else if($pieces[0] == 'summoners')
				{
					$this->site->database->doQuery('SELECT * FROM LOL_SUMMONERS WHERE id = ?', $pieces[1]);
					$row = $this->site->database->doRead();
					$content = '<img src="' . SUMMONERS_DIR . strtolower($row['summoner_image']) . '.png"><br><font color="orange">' . $row['summoner_name'] . '</font><br><br>' . $row['summoner_icerik'];
				}
				else if($pieces[0] == 'items')
				{
					$this->site->database->doQuery('SELECT * FROM LOL_ITEMS WHERE item_id = ?', $pieces[1]);
					$row = $this->site->database->doRead();
					$content = '<img src="' . ITEMS_DIR . $row['item_id'] . '.png"><br><font color="orange">' . $row['item_adi'] . '</font><br><font color="857127">Tekli Fiyatı</font> <font color="yellow">(' . $row['item_teklifiyat'] . ')</font> <font color="857127">Toplam Fiyatı</font> <font color="yellow">(' . $row['item_toplamfiyat'] . ')</font><hr>' .  $row['item_icerik'];
				}
				else if($safec0 == 'masteries')
				{
					$this->site->database->doQuery('SELECT * FROM LOL_MASTERIES WHERE EN_skillname = ?', $safec1);
					$row = $this->site->database->doRead();
					$content = '<img src="' . MASTERIES_DIR . $row['imgPath'] . '"><br><font color="orange">' . $row['TR_skillname'] . '</font><br><br>' . $row['TR'];
				}
				else
				{
					$content = 'Beklenmedik bir hata oluştu.';
				}	
			}
			
			$this->content = Template::Load('page.ajax_content', array('AJAX_CONTENT' => $content));
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