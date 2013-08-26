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
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_INDEX_TITLE'));
		}

		function Run()
		{
			Template::SetVar('HABERLER', $this->getNews());
			Template::SetVar('POPULER_BUILDS', $this->getPopulerBuilds());
			Template::SetVar('LAST_BUILDS', $this->getLastBuilds());
			
			$this->setLiveStreams();
			
			$this->content = Template::Load('main_content');
		}
		
		function setLiveStreams()
		{
			$curl = curl_init();	
			curl_setopt($curl, CURLOPT_URL, "https://api.twitch.tv/kraken/streams?channel=wingsofdeath,athenelive,tsm_dyrus,tsm_theoddone,hotshotgg,voyboy,nyjacky,dandinh,phantoml0rd,falkenmire");
			curl_setopt($curl, CURLOPT_HEADER, FALSE); 
			curl_setopt($curl, CURLOPT_NOBODY, FALSE); 
			curl_setopt($curl, CURLOPT_REFERER,""); 
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
			
			$response = curl_exec($curl);
			$results = json_decode($response, true);
					
			foreach($results['streams'] as $k => $v)
			{
				$val = $k + 1;
				Template::SetVar('SPOTLIGHT_' . $val . '_STATUS', $v['channel']['status'] . '(' . $v['viewers'] . ')'); 
				Template::SetVar('SPOTLIGHT_' . $val . '_IMAGE', '<img src="' . $v['preview'] . '">');
			}
		}
		
		function getNews()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('SELECT * FROM LOL_HABER ORDER BY id DESC LIMIT 0,5');
			$news = NULL; 
			while ($row = $db->doRead())
			{
				if(strlen($row['icerik']) > 450)
				{
					$icerik = substr($row['icerik'], 0, 450);
					$icerik .= '...<div align="right"><a href="' . $this->site->config['SITE']['HOST'] . '#!haber_build-' . $row['sef'] . '-' . $row['id'] . '.html" style="color: #333333; text-decoration: none;">- Devamını oku</a></div>';
				}
				else
				{
					$icerik = $row['icerik'];
				}
				
				if($row['readcount'] > 999)
				{
					$okunmaSayisi = str_replace((substr($row['readcount'], -3)), 'k', $row['readcount']);
				}
				else
				{
					$okunmaSayisi = $row['readcount'];
				}
				
				$news .= Template::Load('haberler_part', array('HABER_ID' => $row['id'], 'HABER_TARIH' => $row['tarih'], 'HABER_BASLIK' => $row['baslik'], 'HABER_ICERIK' => $icerik, 'HABER_YAZAR' => $row['yazar'], 'HABER_IMG' => $row['img'], 'HABER_SEF' => $row['sef'], 'HABER_YORUM_SAYISI' => $okunmaSayisi));
			}
			return $news;
		}
		
		function getPopulerBuilds()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 ORDER BY positive_votes DESC, LOL_BUILDS.id DESC LIMIT 0,4');
			if ($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			$content = NULL; 
			while ($row = $db->doRead())
			{
				
				//Fix division by 0 issue when handling vote ratio
				$negativeVotes = ($row['negative_votes'] == 0) ? 1 : $row['negative_votes'];
				$positiveVotes = ($row['positive_votes'] == 0) ? 1 : $row['positive_votes'];
				
				//Handle top tags (approved, old, pro etc)
				//Set everything to null by default
				Template::SetVar('TAG_PRO', NULL);
				Template::SetVar('TAG_SOBAFIRE', NULL);
				Template::SetVar('TAG_APPROVED', NULL);
				Template::SetVar('TAG_FRESHNESS', NULL);
				
				//Start adding the actual tags
				if($row['status'] == 'pro')
					Template::SetVar('TAG_PRO', '<img src="./themes/default/images/builds/pro.jpg">');
				
				if($row['status'] == 'sobafire')
					Template::SetVar('TAG_SOBAFIRE', '<img src="./themes/default/images/builds/sobafire.jpg">');
				
				if($row['isApproved'] == 1) //approved
					Template::SetVar('TAG_APPROVED', '<img src="./themes/default/images/builds/onaylandi.jpg">');
				
				if($row['isApproved'] == 2) //troll
					Template::SetVar('TAG_APPROVED', '<img src="./themes/default/images/builds/onaylandi.jpg">');
					
				if($row['timestamp'] >= (time() - (60 * 60 * 24 * 90)))
				{
					Template::SetVar('TAG_FRESHNESS', '<img src="./themes/default/images/builds/guncel.jpg">');
				}
				else
				{
					Template::SetVar('TAG_FRESHNESS', '<img src="./themes/default/images/builds/eski.jpg">');
				}
				
				
				//Addition of new build backgrounds (pro, sobafire etc.)
				if($row['status'] == 'pro')
				{
					$content .= Template::Load('main_content.popularbuilds.pro.part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else if($row['status'] == 'sobafire')
				{
					$content .= Template::Load('main_content.popularbuilds.sobafire.part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else
				{
					$content .= Template::Load('main_content.popularbuilds.part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
			}
			return $content;
		}
		
		function getLastBuilds()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 ORDER BY LOL_BUILDS.id DESC LIMIT 0,4');
			if ($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			$content = NULL; 
			while ($row = $db->doRead())
			{
				
				//Fix division by 0 issue when handling vote ratio
				$negativeVotes = ($row['negative_votes'] == 0) ? 1 : $row['negative_votes'];
				$positiveVotes = ($row['positive_votes'] == 0) ? 1 : $row['positive_votes'];
				
				//Handle top tags (approved, old, pro etc)
				//Set everything to null by default
				Template::SetVar('TAG_PRO', NULL);
				Template::SetVar('TAG_SOBAFIRE', NULL);
				Template::SetVar('TAG_APPROVED', NULL);
				Template::SetVar('TAG_FRESHNESS', NULL);
				
				//Start adding the actual tags
				if($row['status'] == 'pro')
					Template::SetVar('TAG_PRO', '<img src="./themes/default/images/builds/pro.jpg">');
				
				if($row['status'] == 'sobafire')
					Template::SetVar('TAG_SOBAFIRE', '<img src="./themes/default/images/builds/sobafire.jpg">');
				
				if($row['isApproved'] == 1) //approved
					Template::SetVar('TAG_APPROVED', '<img src="./themes/default/images/builds/onaylandi.jpg">');
				
				if($row['isApproved'] == 2) //troll
					Template::SetVar('TAG_APPROVED', '<img src="./themes/default/images/builds/onaylandi.jpg">');
					
				if($row['timestamp'] >= (time() - (60 * 60 * 24 * 90)))
				{
					Template::SetVar('TAG_FRESHNESS', '<img src="./themes/default/images/builds/guncel.jpg">');
				}
				else
				{
					Template::SetVar('TAG_FRESHNESS', '<img src="./themes/default/images/builds/eski.jpg">');
				}
				
				
				//Addition of new build backgrounds (pro, sobafire etc.)
				if($row['status'] == 'pro')
				{
					$content .= Template::Load('main_content.popularbuilds.pro.part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else if($row['status'] == 'sobafire')
				{
					$content .= Template::Load('main_content.popularbuilds.sobafire.part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else
				{
					$content .= Template::Load('main_content.popularbuilds.part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
			}
			return $content;
		}
		
		function getPercent($num_amount, $num_total) 
		{
			if($num_total == 0)
			{
				return '50';
			}
			
			$count1 = $num_amount / $num_total;
			$count2 = $count1 * 100;
			$count = number_format($count2, 0);
			
			return $count;
		}
		
		function getBackgroundColor($count)
		{
			if($count > 80)
			{
				return '#86e01e';
			}
			else if(($count <=  80) && ($count > 60))
			{
				return '#f2d31b';
			}
			else if(($count <=  60) && ($count > 40))
			{
				return '#f2b01e';
			}
			else if(($count <=  40) && ($count > 20))
			{
				return '#f27011';
			}
			else
			{
				return '#f63a0f';
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