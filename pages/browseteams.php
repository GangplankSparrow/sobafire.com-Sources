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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . 'Takım Listesi');
		}

		function Run()
		{	
			Template::SetVar('BROWSE_TEAMS_CONTENT', $this->getAllTeams());
			$this->content = Template::Load('browseteams');
		}
		
		function getAllTeams()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('select LOL_TEAMS.id, LOL_TEAMS.Name, LOL_TEAMS.Creator, LOL_TEAMS.CreationDate, LOL_TEAMS.lolServer, LOL_TEAMS.lolTeamName, LOL_TEAMS.lolTeamElo, LOL_TEAMS.Points, LOL_TEAMS.Rating, (select count(*) from LOL_TEAM_MEMBERS where team_id=LOL_TEAMS.id) as total_members FROM LOL_TEAMS ORDER BY LOL_TEAMS.Rating DESC, LOL_TEAMS.id DESC');
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
				$content .= Template::Load('browseteams.part', array('NUM' => $i, 'TEAM_ID' => $row['id'], 'LOGO' => $row['LOGO'], 'TEAM_NAME' => $row['Name'], 'TEAM_ELO' => $row['lolTeamElo'], 'TEAM_POINTS' => $row['Points'], 'TEAM_RATING' => $row['Rating'], 'TEAM_LOL_NAME' => $row['lolTeamName'], 'TEAM_LOL_SRV' => $this->getServerNameByNum($row['lolServer']), 'TEAM_MEMBER_AMOUNT' => $row['total_members']));
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