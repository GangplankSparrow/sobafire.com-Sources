<?php

if (!defined ("ARISTONA") || ARISTONA != 1)
        die ();

class Misc
{
	function __construct() {}
		
	/**
	* Formats a timestamp nicely with an adaptive "x units of time ago" message.
	* Based on the original Twitter JavaScript badge. Only handles past dates.
	* @return string Nicely-formatted message for the timestamp.
	* @param $time Output of strtotime() on your choice of timestamp.
	* echo niceTime(strtotime('2011-12-10 03:14:07'));
	*/
		
	function niceTime($time) 
	{
		$delta = time() - $time;
		if ($delta < 60) { return 'less than a minute ago.'; } 
		else if ($delta < 120) { return 'about a minute ago.'; } 
		else if ($delta < (45 * 60)) { return floor($delta / 60) . ' minutes ago.'; } 
		else if ($delta < (90 * 60)) { return 'about an hour ago.'; } 
		else if ($delta < (24 * 60 * 60)) { return 'about ' . floor($delta / 3600) . ' hours ago.'; } 
		else if ($delta < (48 * 60 * 60)) { return '1 day ago.'; } 
		else { return floor($delta / 86400) . ' days ago.'; }
	}
		
	function sefLink($s)
	{  
		$tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','ç','Ç');  
		// Türkçe karakterlerin çevirlecegi karakterler  
		$en = array('s','s','i','i','g','g','u','u','o','o','c','c');  
		$s = str_replace($tr,$en,$s);  
		$s = strtolower($s);  
		$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '-', $s);  
		$s = preg_replace('/[^%a-z0-9 _-]/', '-', $s);  
		$s = preg_replace('/\s+/', '-', $s);  
		$s = preg_replace('|-+|', '-', $s);  
		$s = str_replace("--","-",$s);  
		$s = trim($s, '-');  
		return $s;  
	}  
		
	function addCometHistory($input)
	{
		if(file_exists('./cache/__comet.log'))
			file_put_contents('./cache/__comet.log', $input);
		else
			echo "comet.log bulunamadı.";
	}
		
	function __destruct() {}
}

?>