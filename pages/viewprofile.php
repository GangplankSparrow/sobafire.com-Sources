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
			Template::SetVar('title', $this->config['SITE']['TITLE'] . $this->site->SanitizeName($_GET['username']) . ' Profili');
		}

		function Run()
		{
			if (!isset($_GET['username']))
			{
				$this->Error('ERROR_USER_NOT_FOUND');
				return;
			}
      
			$user = $this->site->SanitizeName($_GET['username']);
			$num_rows = $this->database->doQuery('SELECT * FROM USERDATA WHERE Username = ?', $user);
			if ($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			elseif ($num_rows == 0)
			{
				$this->Error('ERROR_USER_NOT_FOUND');
				return;
			}
			
			$row = $this->database->doRead();
			
			Template::SetVar('PROFILE_USERNAME', $row['Username']);
			Template::SetVar('PROFILE_REALNAME', $row['Realname']);
			Template::SetVar('PROFILE_REALSIRNAME', $row['Realsirname']);
			Template::SetVar('PROFILE_LOLACC', $row['lolAcc']);
			Template::SetVar('PROFILE_LOLSERVER', $this->getLolServerName($row['lolServer']));
			Template::SetVar('PROFILE_TEXTYETKI', $this->site->getPermission($row['Yetki']));
			Template::SetVar('PROFILE_AVATAR_ID', $row['avatarID']);
			Template::SetVar('PROFILE_FAVCHAMP_ID', $row['favoriteChampID']);
			Template::SetVar('PROFILE_COUNT_BUILDS', $this->getCountBuilds($user));
			Template::SetVar('PROFILE_COUNT_POSITIVE_VOTES', $this->getCountPositiveVotes($user));
			Template::SetVar('PROFILE_COUNT_NEGATIVE_VOTES', $this->getCountNegativeVotes($user));
			Template::SetVar('PROFILE_COUNT_COMMENTS', $this->getCountComments($user));

			$this->getEloPoints($row['lolAcc'], $row['lolServer']);
			
			//--Update Comet History
			if (isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == TRUE) 
			{
				$this->site->misc->addCometHistory($_SESSION['Username'] . ', ' . $row['Username'] . ' kullanıcısının profilini inceliyor.');
			}
			else
			{
				$this->site->misc->addCometHistory($this->site->GetRemoteIP() . ', ' . $row['Username'] . ' kullanıcısının profilini inceliyor.');
			}
			
			$this->content = Template::Load('viewprofile');
			
		}
		
		function getCountBuilds($user)
		{
			$this->site->database->doQuery('SELECT count(*) as Toplam FROM LOL_BUILDS WHERE writer = ? AND isVisible = 1', $user);
			$row = $this->site->database->doRead();
			return $row['Toplam'];
		}
		
		function getCountPositiveVotes($user)
		{
			$this->site->database->doQuery('SELECT count(*) as Toplam FROM LOL_BUILD_VOTES WHERE voter = ? AND vote = 1', $user);
			$row = $this->site->database->doRead();
			return $row['Toplam'];
		}
		
		function getCountNegativeVotes($user)
		{
			$this->site->database->doQuery('SELECT count(*) as Toplam FROM LOL_BUILD_VOTES WHERE voter = ? AND vote = 0', $user);
			$row = $this->site->database->doRead();
			return $row['Toplam'];
		}
		
		function getCountComments($user)
		{
			$this->site->database->doQuery('SELECT count(*) as Toplam FROM LOL_BUILD_COMMENTS WHERE yorumcu = ?', $user);
			$row = $this->site->database->doRead();
			return $row['Toplam'];
		}
		
		function getLolServerName($serverID)
		{
			switch($serverID)
			{
				case 1:
					return 'EU East & Nordic';
					break;
					
				case 2:
					return 'EU West';
					break;	
					
				case 3:
					return 'USA';
					break;
					
				default:
					return 'Belirtilmemiş';
			}
		}
		
		function getEloPoints($acc, $server)
		{
			if($acc == 'Unknown')
			{
				Template::SetVar('PROFILE_LOLACCELOTYPE_1', 'Bu üye karakterini belirtmemiş.');
				Template::SetVar('PROFILE_LOLACCELOTYPE_2', 'Bu üye karakterini belirtmemiş.');
				Template::SetVar('PROFILE_LOLACCELOTYPE_3', 'Bu üye karakterini belirtmemiş.');
				Template::SetVar('PROFILE_LOLACCELOTYPE_4', 'Bu üye karakterini belirtmemiş.');
				return;
			}
			
			$curl = curl_init(); 
			
			if($server == 1)
			{
				curl_setopt($curl, CURLOPT_URL, "http://competitive.euw.leagueoflegends.com/ladders/eune/current/rankedsolo5x5?summoner_name=" . $acc); 
			}
			
			if($server == 2)
			{
				curl_setopt($curl, CURLOPT_URL, "http://competitive.euw.leagueoflegends.com/ladders/euw/current/rankedsolo5x5?summoner_name=" . $acc); 
			}
			
			if ($server == 3)
			{
				curl_setopt($curl, CURLOPT_URL, "http://competitive.euw.leagueoflegends.com/ladders/na/current/rankedsolo5x5?summoner_name=" . $acc); 
			}

			curl_setopt($curl, CURLOPT_HEADER, FALSE); 
			curl_setopt($curl, CURLOPT_NOBODY, FALSE); 
			curl_setopt($curl, CURLOPT_REFERER,""); 
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
			
			$gelenveri = curl_exec($curl);
			
			$veri = explode('<tr class="odd views-row-first views-row-last">', $gelenveri);
			$veri = explode('<div id="return_link">', $veri[1]);
			$veriFinal = $veri[0];
			$veriFinal = str_replace('<td class="views-field views-field-rank views-align-center" >', '', $veriFinal);
			$veriFinal = str_replace('<td class="views-field views-field-summoner-name-1" >', '', $veriFinal);
			$veriFinal = str_replace('<td class="views-field views-field-roster-json" >', '', $veriFinal);
			$veriFinal = str_replace('<td class="views-field views-field-wins views-align-center" >', '', $veriFinal);
			$veriFinal = str_replace('<td class="views-field views-field-losses views-align-center" >', '', $veriFinal);
			$veriFinal = str_replace('<td class="views-field views-field-rating views-align-center" >', '', $veriFinal);
			
			$veriArray = explode('</td>', $veriFinal);
			
			if($veriArray[0] == 0)
			{
				Template::SetVar('PROFILE_LOLACCELOTYPE_1', 'Sıralamada değil.');
				Template::SetVar('PROFILE_LOLACCELOTYPE_2', 'Sıralamada değil.');
				Template::SetVar('PROFILE_LOLACCELOTYPE_3', 'Sıralamada değil.');
				Template::SetVar('PROFILE_LOLACCELOTYPE_4', 'Sıralamada değil.');
			}
			else
			{
				Template::SetVar('PROFILE_LOLACCELOTYPE_1', $veriArray[0]);
				Template::SetVar('PROFILE_LOLACCELOTYPE_2', $veriArray[3]);
				Template::SetVar('PROFILE_LOLACCELOTYPE_3', $veriArray[4]);
				Template::SetVar('PROFILE_LOLACCELOTYPE_4', $veriArray[5]);
				$this->site->database->doQuery('UPDATE USERDATA SET lolCurrentElo = ? WHERE lolAcc = ?', intval($veriArray[5]), $acc);
			}
			
			curl_close($curl);			
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