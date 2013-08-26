<?php
	
	if (!defined('ARISTONA') || ARISTONA != 1)
		die();

	class BBCode
	{
		protected $site, $database, $content, $replace;
		protected $cacheable = TRUE;
		protected $cacheTime = 600;

		function __construct($site)
		{
			$this->site = $site;
			$this->config = $site->config;
			$this->database = $site->database;
		}
		
		function readBBCode($string)
		{
			$string = $this->tagYou($string);
			return $string;
		}
		
		function tagYou($string)
		{
			if($this->site->loggedIn())
			{
				$result = str_replace('[you]', $_SESSION['Username'], $string);
			}
			else
			{
				$result = str_replace('[you]', 'Misafir', $string);
			}
			
			return $result;
		}
		
		/*
			Veritabanına yorum eklerken postBBCode() fonksiyonundan geçirmelisin.
			Bu fonksiyon [b] tarzı tagları replace ettirir.
		*/
		
		function postBBCode($string)
		{
			$string = str_replace('http://', '', $string);
			$string = str_replace('?', '&#63;', $string);
			$string = str_replace('<', '&#60;', $string);
			$string = nl2br($string);
			$string = strip_tags($string, '<br></br>');
			$string = $this->tagB($string);
			$string = $this->tagI($string);
			$string = $this->tagU($string);
			$string = $this->tagLink($string);
			$string = $this->tagImage($string);
			$string = $this->tagYoutube($string);
			$string = $this->tagOwn3d($string);
			$string = $this->tagTwitch($string);
			$string = $this->tagItem($string);
			$string = $this->tagSkill($string);
			return $string;
		}
		
		function tagB($string)
		{
			$result = str_replace('[b]', '<b>', $string);
			$result = str_replace('[/b]', '</b>', $result);
			return $result;
		}
		
		function tagI($string)
		{
			$result = str_replace('[i]', '<i>', $string);
			$result = str_replace('[/i]', '</i>', $result);
			return $result;
		}
		
		function tagU($string)
		{
			$result = str_replace('[u]', '<u>', $string);
			$result = str_replace('[/u]', '</u>', $result);
			return $result;
		}
		
		function tagYoutube($string)
		{
			$results = array();
			preg_match_all('#\[youtube\](.*?)\[\/youtube\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				if(substr($v, 0, 28) != 'www.youtube.com/watch&#63;v=')
				{
					$string = str_replace('[youtube]' . $v . '[/youtube]', '(Hatalı youtube linki)', $string);
				}
				else
				{
					$movieID = substr($v, 28, 11);
					$string = str_replace('[youtube]' . $v . '[/youtube]', '<div align="center"><iframe width="560" height="315" src="http://www.youtube.com/embed/' . $movieID . '" frameborder="0" allowfullscreen></iframe></div>', $string);
				}
			}
			return $string;
		}
		
		function tagOwn3d($string)
		{
			$results = array();
			preg_match_all('#\[own3d\](.*?)\[\/own3d\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				$string = str_replace('[own3d]' . $v . '[/own3d]', '<div align="center"><object width="640" height="360"><param name="movie" value="http://www.own3d.tv/stream/' . $v . '" /><param name="allowscriptaccess" value="always" /><param name="allowfullscreen" value="true" /><param name="wmode" value="transparent" /><embed src="http://www.own3d.tv/stream/' . $v . '" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="360" wmode="transparent"></embed></object></div>', $string);
			}
		
			return $string;
		}
		
		function tagTwitch($string)
		{
			$results = array();
			preg_match_all('#\[twitch\](.*?)\[\/twitch\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				$string = str_replace('[twitch]' . $v . '[/twitch]', 'twitch.tv videosu (yapım aş)', $string);
			}
			return $string;
		}
			
		function tagLink($string)
		{
			$results = array();
			preg_match_all('#\[link\](.*?)\[\/link\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				$string = str_replace('[link]' . $v . '[/link]', '<a href="http://' . $v . '">' . $v . '</a>', $string);
			}
			return $string;
		}
		
		function tagImage($string)
		{
			$results = array();
			preg_match_all('#\[image\](.*?)\[\/image\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				$string = str_replace('[image]' . $v . '[/image]', '<img src="http://' . $v . '">', $string);
			}
			return $string;
		}
		
		function tagItem($string)
		{
			$results = array();
			preg_match_all('#\[item\](.*?)\[\/item\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				$string = str_replace('[item]' . $v . '[/item]', $this->convertIntoItem($v), $string);
			}
			return $string;
		}
		
		function tagSkill($string)
		{
			$results = array();
			preg_match_all('#\[skill\](.*?)\[\/skill\]#', $string, $results);
			
			foreach($results[1] as $k => $v)
			{
				$string = str_replace('[skill]' . $v . '[/skill]', $this->convertIntoSkill($v), $string);
			}
			return $string;
		}
		
		//additional functions
		function convertIntoItem($itemName)
		{
			$num_rows = $this->site->database->doQuery('SELECT item_id FROM LOL_ITEMS WHERE item_adi = ?', $itemName);
			
			if($num_rows == 0)
				return;
			$row = $this->site->database->doRead();
			return '<img src="http://www.sobafire.com/themes/default/images/lol/items/' . $row['item_id'] . '.png" style=" height: 28px; width: 28px;" alt="' . $row['item_adi'] . '" title="items_' . $row['item_id'] . '" />';
		}
		
		function convertIntoSkill($skillName)
		{
			$num_rows = $this->site->database->doQuery('SELECT imgPath, SkillNum FROM LOL_SKILLS WHERE EN_skillname = ?', $skillName);
			
			if($num_rows == 0)
				return;
			$row = $this->site->database->doRead();
			return '<img src="http://www.sobafire.com/themes/default/images/lol/abilities/' . $row['imgPath'] . '" style=" height: 28px; width: 28px;" alt="" title="skills_' . $row['SkillNum'] . '" />';
		}
		
        function __destruct() 
		{
		
		}
}

?>