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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_BROWSE_VIDEOS_TITLE'));
		}

		function Run()
		{	
			if(!isset($_GET['s']))
			{
				$this->basicError('Bu sayfaya direkt erişim sağlayamazsınız.');
				return;
			}
			
			switch(intval($_GET['s']))
			{
				case 1:
					$this->showStreams();
					break;
				
				case 2:
					$this->showYoutubeVideos();
					break;
				
				case 3:
					$this->showLolReplayFiles();
					break;
				
				default:
					$this->getStreams();
			}
		}
		
		//streams
		function showStreams()
		{
				
			/*  ----- ÇOKLU STREAM BULMA ----
				Get all league of legends livestreams
				https://api.twitch.tv/kraken/streams?game=League+of+Legends
				
				Parameters:
					game (optional): The game to query.
					channel (optional): A list of channel names to query, seperated by commas.
					limit (optional): The maximum number of streams to return, up to 100.
					offset (optional): The offset to begin listing streams, defaults to 0.
					embeddable (optional): If true you'll only get streams which can be embedded. Setting this to false will just drop the flag, because that is a weird thing to do!

					Get list of Diablo III streams
					GET /streams?game=Diablo+III
					
					Get multiple channels
					GET /streams?channel=incredibleorb,incontroltv
			*/
				
			/* ----- TEKLİ STREAM BULMA ----
				GET /channels/:channel/
				
				{
				  "name": "towelliee",
				  "game": "World of Warcraft: Cataclysm",
				  "created_at": "2011-02-24T01:38:43Z",
				  "teams": [{
					"name": "tgn",
					"created_at": "2011-12-23T06:30:14Z",
					"background": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-tgn-background_image-1d969c0af8187732.jpeg",
					"banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-tgn-banner_image-f221dbf018f33148-640x125.png",
					"updated_at": "2012-04-25T17:30:49Z",
					"_id": 134,
					"logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/team-tgn-team_logo_image-b710eca274634d81-300x300.png",
					"_links": {
					  "self": "https://api.twitch.tv/kraken/teams/tgn"
					},
					"info": "Building a career path for YouTubers! See http://tgn.tv\n\n",
					"display_name": "TGN"
				  }],
				  "title": "Towelliee HD Gaming",
				  "updated_at": "2012-06-18T05:22:53Z",
				  "banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/towelliee-channel_header_image-7d10ec1bfbef2988-640x125.png",
				  "video_banner": "http://static-cdn.jtvnw.net/jtv_user_pictures/towelliee-channel_offline_image-bdcb1260130fa0cb.png",
				  "background": "http://static-cdn.jtvnw.net/jtv_user_pictures/towelliee-channel_background_image-eebc4eabf0686bb9.png",
				  "_links": {
					"self": "https://api.twitch.tv/kraken/channels/towelliee",
					"chat": "https://api.twitch.tv/kraken/chat/towelliee",
					"videos": "https://api.twitch.tv/kraken/channels/towelliee/videos",
					"video_status": "https://api.twitch.tv/kraken/channels/towelliee/video_status",
					"commercial": "https://api.twitch.tv/kraken/channels/towelliee/commercial"
				  },
				  "logo": "http://static-cdn.jtvnw.net/jtv_user_pictures/towelliee-profile_image-7243b004a2ec3720-300x300.png",
				  "_id": 20694610,
				  "mature": true,
				  "url": "http://www.twitch.tv/towelliee",
				  "display_name": "Towelliee"
				}
			*/
			
			/* CHAT
				GET /chat/:channel
			*/
			
			$curl = curl_init();	
			curl_setopt($curl, CURLOPT_URL, "https://api.twitch.tv/kraken/streams?channel=wingsofdeath,athenelive,tsm_dyrus,tsm_theoddone");
			curl_setopt($curl, CURLOPT_HEADER, FALSE); 
			curl_setopt($curl, CURLOPT_NOBODY, FALSE); 
			curl_setopt($curl, CURLOPT_REFERER,""); 
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); 
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
			
			$response = curl_exec($curl);
			$results = json_decode($response, true);
					
			foreach($results['streams'] as $k => $v)
			{
				echo $v['channel']['status']; //yay works
				echo '<img src="' . $v['preview'] . '">';
			}
			
			$this->content = Template::Load('info', array('ERROR' => 'Şuan hiçbir canlı yayın bulunamadı. Daha sonra tekrar deneyin.'));
			return;
		}
		
		
		//youtube
		function showYoutubeVideos()
		{
			if(!isset($_GET['videoID']))
			{
				$this->content = Template::Load('browsevideos.youtube', array('LINKS' => $this->getAllYoutubeVideoLinks(), 'CURRENT_VIDEO' => NULL, 'YT_ADDCOMMENT' => NULL, 'YT_COMMENTS' => NULL));
			}
			else
			{
				$id = intval($_GET['videoID']);
				Template::SetVar('YT_COMMENTS', NULL); //$this->showComments($id));
				Template::SetVar('YT_ADDCOMMENT', NULL); //$this->showCommentingForm());
				$this->content = Template::Load('browsevideos.youtube', array('LINKS' => $this->getAllYoutubeVideoLinks(), 'CURRENT_VIDEO' => $this->showYoutubeVideo($id)));
			}
		}
		
		function showYoutubeVideo($id)
		{
			$this->site->database->doQuery('SELECT * FROM LOL_VIDEOS WHERE id = ?', $id);
			$row = $this->site->database->doRead();
			return '<iframe width="790" height="455" src="http://www.youtube.com/embed/' . $row['link'] . '?hd=1" frameborder="0" allowfullscreen></iframe>';
		}
		
		function getAllYoutubeVideoLinks()
		{
			$this->site->database->doQuery('SELECT * FROM LOL_VIDEOS WHERE type = \'YOUTUBE\'');
			$content = null;
			while($row = $this->site->database->doRead())
			{
				$content .= Template::Load('browsevideos.youtube.links', array('YT_DESCRIPTION' => $row['description'], 'YT_ID' => $row['id']));
			}
			return $content;
		}
		
		function showCommentingForm()
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{
				return 'Bu videoya yorum yapabilmek için önce giriş yapmış olmanız gerekiyor.';
			}
			else
			{
				return Template::Load('browsevideos.addcomment');
			}
		}
		
		function showComments($buildID)
		{
			$this->database->doQuery('select bc.id, bc.tarih, bc.yorum, bc.yorumcu, (select avatarID from USERDATA where Username=bc.yorumcu) as avatarID FROM LOL_BUILD_COMMENTS bc WHERE bc.build_id = ? ORDER BY id DESC', $buildID);
		
			$comments = NULL; 
			while ($row = $this->database->doRead())
			{
				$comments .= Template::Load('build.comments', array('YORUM_ID' => $row['id'], 'YORUM_TARIH' => $row['tarih'], 'YORUM_ICERIK' => $row['yorum'], 'YORUM_YORUMCU' => $row['yorumcu'], 'USER_AVATAR' => $row['avatarID']));
			}
			
			if(strlen($comments) < 1)
			{
				return 'Bu videoya hiç yorum yapılmamış.';
			}
			else
			{
				return $this->site->bbcode->readBBCode($comments);
			}
		}
		
		
		
		//lolreplay
		function showLoLReplayFiles()
		{
			$this->content = Template::Load('info', array('ERROR' => 'Şuan hiçbir LOLReplay dosyası bulunamadı. Daha sonra tekrar deneyin.'));
			return;
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