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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_BROWSE_USERS_TITLE'));
		}

		function Run()
		{	
			Template::SetVar('BROWSE_USERS_CONTENT', $this->getAllUsers());
			$this->content = Template::Load('browseusers');
		}
		
		function getAllUsers()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('select b.Username, b.avatarID, b.lolCurrentElo, b.lolServer, b.lolAcc, (select count(*) from lol_build_votes where voter=b.Username and vote = 1) as positive_votes,
  (select count(*) from lol_build_votes where voter=b.Username and vote = 0) as negative_votes FROM USERDATA b ORDER BY b.lolCurrentElo DESC, b.Username');
			if ($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			$content = NULL; 
			$i = 0;
			while ($row = $db->doRead())
			{
				$i++;
				if($row['negative_votes'] == 0)
				{
					$negativeVotes = 0;
				}
				else
				{
					$negativeVotes = $row['negative_votes'];
				}
				
				if($row['positive_votes'] == 0)
				{
					$positiveVotes = 0;
				}
				else
				{	
					$positiveVotes = $row['positive_votes'];
				}
				
				$content .= Template::Load('browseusers_part', array('NUM' => $i, 'AVATAR_ID' => $row['avatarID'], 'BROWSEUSERS_USERNAME' => $row['Username'], 'USER_CURRENT_ELO' => ($row['lolCurrentElo'] == '0' ? '' : $row['lolCurrentElo']), 'USER_LOL_CHAR' => ($row['lolAcc'] == 'Unknown' ? '' : $row['lolAcc']), 'USER_LOL_SRV' => $this->getServerNameByNum($row['lolServer']), 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes))));
			}
			return $content;
		}
		
		function getServerNameByNum($in)
		{
			switch(intval($in))
			{
				case 1:
					return 'EU Nordic & East';
					break;
					
				case 2:
					return 'EU West';
					break;
					
				case 3:
					return 'North America';
					break;
				
				default:
					return '?';
			}
		}
		
		function getPercent($num_amount, $num_total) 
		{
			if($num_total == 0)
			{
				return '<font color="orange">%50</font>';
			}
			
			$count1 = $num_amount / $num_total;
			$count2 = $count1 * 100;
			$count = number_format($count2, 0);
			
			if($count <= 30)
			{
				return '<font color="red">%' . $count . '</font>';
			}
			else if($count > 30 && $count < 75)
			{
				return '<font color="orange">%' . $count . '</font>';
			}
			else
			{
				return '<font color="green">%' . $count . '</font>';
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