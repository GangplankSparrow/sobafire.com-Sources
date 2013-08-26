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
			Template::SetVar('title', $this->config['SITE']['TITLE'] . 'Turnuva Sayfası');
		}

		function Run()
		{
			Template::SetVar('infoarea', '<@bilgi@>');
			Template::SetVar('error', 'Yapım aşamasındadır ve pre-alpha versiyondur. Gördüğünüz veriler uydurmadır - hatalar olabilir.');
			
			Template::SetVar('ROUND1_MATCH1', Template::Load('tournament.round1.singleteam.lower', array('MATCH_NUM' => 1, 
																										'TEAM1_TEAMNAME' => 'CLG',
																										'TEAM1_IS_WINNER' => 'winner',
																										'TEAM1_SCORE' => 2,
																										'TEAM1_TRACENUM' => 1,
																										
																										'TEAM2_TEAMNAME' => 'TSM',
																										'TEAM2_IS_WINNER' => null,
																										'TEAM2_SCORE' => 0,
																										'TEAM2_TRACENUM' => 2)));
																										
			Template::SetVar('ROUND1_MATCH2', Template::Load('tournament.round1.singleteam.upper', array('MATCH_NUM' => 2, 
																										'TEAM1_TEAMNAME' => 'Sobafire.Com',
																										'TEAM1_IS_WINNER' => 'winner',
																										'TEAM1_SCORE' => 2,
																										'TEAM1_TRACENUM' => 3,
																										
																										'TEAM2_TEAMNAME' => 'CLG.EU',
																										'TEAM2_IS_WINNER' => null,
																										'TEAM2_SCORE' => 0,
																										'TEAM2_TRACENUM' => 4)));
																										
			Template::SetVar('ROUND1_MATCH3', Template::Load('tournament.round1.singleteam.lower', array('MATCH_NUM' => 3, 
																										'TEAM1_TEAMNAME' => 'MYM',
																										'TEAM1_IS_WINNER' => null,
																										'TEAM1_SCORE' => 0,
																										'TEAM1_TRACENUM' => 5,
																										
																										'TEAM2_TEAMNAME' => 'V8',
																										'TEAM2_IS_WINNER' => 'winner',
																										'TEAM2_SCORE' => 1,
																										'TEAM2_TRACENUM' => 6)));
																										
			Template::SetVar('ROUND1_MATCH4', Template::Load('tournament.round1.singleteam.upper', array('MATCH_NUM' => 4, 
																										'TEAM1_TEAMNAME' => 'Epik',
																										'TEAM1_IS_WINNER' => 'winner',
																										'TEAM1_SCORE' => 1,
																										'TEAM1_TRACENUM' => 7,
																										
																										'TEAM2_TEAMNAME' => 'LLL',
																										'TEAM2_IS_WINNER' => null,
																										'TEAM2_SCORE' => 0,
																										'TEAM2_TRACENUM' => 8)));
																										
			Template::SetVar('ROUND1_MATCH5', Template::Load('tournament.round1.singleteam.lower', array('MATCH_NUM' => 5, 
																										'TEAM1_TEAMNAME' => 'TG',
																										'TEAM1_IS_WINNER' => 'winner',
																										'TEAM1_SCORE' => 2,
																										'TEAM1_TRACENUM' => 9,
																										
																										'TEAM2_TEAMNAME' => 'aAa',
																										'TEAM2_IS_WINNER' => null,
																										'TEAM2_SCORE' => 0,
																										'TEAM2_TRACENUM' => 10)));
																										
			Template::SetVar('ROUND1_MATCH6', Template::Load('tournament.round1.singleteam.upper', array('MATCH_NUM' => 6, 
																										'TEAM1_TEAMNAME' => 'Curse',
																										'TEAM1_IS_WINNER' => 'winner',
																										'TEAM1_SCORE' => 3,
																										'TEAM1_TRACENUM' => 11,
																										
																										'TEAM2_TEAMNAME' => 'SK',
																										'TEAM2_IS_WINNER' => null,
																										'TEAM2_SCORE' => 0,
																										'TEAM2_TRACENUM' => 12)));
																										
			Template::SetVar('ROUND1_MATCH7', Template::Load('tournament.round1.singleteam.lower', array('MATCH_NUM' => 7, 
																										'TEAM1_TEAMNAME' => 'MiG',
																										'TEAM1_IS_WINNER' => null,
																										'TEAM1_SCORE' => 1,
																										'TEAM1_TRACENUM' => 13,
																										
																										'TEAM2_TEAMNAME' => 'TSM.EU',
																										'TEAM2_IS_WINNER' => 'winner',
																										'TEAM2_SCORE' => 2,
																										'TEAM2_TRACENUM' => 14)));
																										
			Template::SetVar('ROUND1_MATCH8', Template::Load('tournament.round1.singleteam.upper', array('MATCH_NUM' => 8, 
																										'TEAM1_TEAMNAME' => 'M5',
																										'TEAM1_IS_WINNER' => 'winner',
																										'TEAM1_SCORE' => 3,
																										'TEAM1_TRACENUM' => 15,
																										
																										'TEAM2_TEAMNAME' => 'FN',
																										'TEAM2_IS_WINNER' => null,
																										'TEAM2_SCORE' => 0,
																										'TEAM2_TRACENUM' => 16)));
											
			$this->content = Template::Load('tournament.bracket.x16');
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