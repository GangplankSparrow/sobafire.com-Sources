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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_BROWSE_BUILDS_TITLE'));
		}

		function Run()
		{	
			if(isset($_GET['champID']))
			{	
				Template::SetVar('BROWSE_BUILDS_CONTENT', $this->getBuildsByChampID($_GET['champID']));
				Template::SetVar('info', '<@bilgi@>');
				Template::SetVar('error', 'Seçilen şampiyona ait tüm buildler gösteriliyor.');
			}
			else if(isset($_GET['type']))
			{
				switch(intval($_GET['type']))
				{
					case 1:
						Template::SetVar('BROWSE_BUILDS_CONTENT', $this->getBuilds('sobafire'));
						Template::SetVar('info', '<@bilgi@>');
						Template::SetVar('error', 'Sadece Team Sobafire takım üyelerinin oluşturduğu buildler gösteriliyor.');
						break;
						
					case 2:
						Template::SetVar('BROWSE_BUILDS_CONTENT', $this->getBuilds('pro'));
						Template::SetVar('info', '<@bilgi@>');
						Template::SetVar('error', 'Sadece profesyonel oyuncuların oluşturduğu buildler gösteriliyor.');
						break;
						
					default:
						Template::SetVar('BROWSE_BUILDS_CONTENT', $this->getBuilds('all'));
						Template::SetVar('info', '<@bilgi@>');
						Template::SetVar('error', 'Tüm buildler gösteriliyor.');
				}
			}
			else
			{
				Template::SetVar('BROWSE_BUILDS_CONTENT', $this->getBuilds('all'));
				Template::SetVar('info', '<@bilgi@>');
				Template::SetVar('error', 'Tüm buildler gösteriliyor.');
			}
			
			$this->content = Template::Load('browsebuilds');
		}
		
		function getBuilds($type = 'all')
		{
			switch($type)
			{
				case 'all': {
					$query = 'select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 ORDER BY positive_votes DESC, LOL_BUILDS.id DESC';
				} break;
				
				case 'sobafire': {
					$query = 'select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 AND USERDATA.status = \'sobafire\' ORDER BY positive_votes DESC, LOL_BUILDS.id DESC';
				} break;
				
				case 'pro': {
					$query = 'select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 AND USERDATA.status = \'pro\' ORDER BY positive_votes DESC, LOL_BUILDS.id DESC';
				} break;
					
				default: {
					$query = 'select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 ORDER BY positive_votes DESC, LOL_BUILDS.id DESC';
				} 
			}
		
			$db = $this->database;
			$num_rows = $db->doQuery($query);
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
					$content .= Template::Load('browsebuilds_pro_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else if($row['status'] == 'sobafire')
				{
					$content .= Template::Load('browsebuilds_sobafire_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else if($row['isApproved'] == 2)
				{
					$content .= Template::Load('browsebuilds_troll_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else
				{
					$content .= Template::Load('browsebuilds_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
			}
			return $content;
		}
		
		function getBuildsByChampID($champID = 0)
		{
			
			$champID = intval($champID);
	
			$db = $this->database;
			$num_rows = $db->doQuery('select LOL_BUILDS.id, LOL_BUILDS.champNum, LOL_BUILDS.writer, LOL_BUILDS.buildName, LOL_BUILDS.sefLink, LOL_BUILDS.isApproved, LOL_BUILDS.timestamp,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 1) as positive_votes,
			(select count(*) from lol_build_votes where build_id=LOL_BUILDS.id and vote = 0) as negative_votes, 
			USERDATA.lolCurrentElo, USERDATA.Username, USERDATA.Status as status FROM LOL_BUILDS 
			INNER JOIN USERDATA ON LOL_BUILDS.writer=USERDATA.Username WHERE LOL_BUILDS.isVisible = 1 AND LOL_BUILDS.champNum = ? ORDER BY positive_votes DESC, LOL_BUILDS.id DESC', $champID);
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
					$content .= Template::Load('browsebuilds_pro_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else if($row['status'] == 'sobafire')
				{
					$content .= Template::Load('browsebuilds_sobafire_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else if($row['isApproved'] == 2)
				{
					$content .= Template::Load('browsebuilds_troll_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
				}
				else
				{
					$content .= Template::Load('browsebuilds_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)), 'VOTE_BACKGROUND_COLOR' =>  $this->getBackgroundColor($this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)))));
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

		function ShowMain()
		{
			$this->content = Template::Load('account');
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