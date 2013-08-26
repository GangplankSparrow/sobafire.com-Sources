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

			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_MY_ACCOUNT_TITLE'));
		}

		function Run()
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{
				$this->content = Template::Load('error', array('error' => Template::GetLangVar('ERROR_LOGIN_REQUIRED')));
				return;
			}
			
			switch (@$this->site->SanitizeName($_GET['s']))
			{
				case 'changeavatar':
					$this->changeAvatar();
					break;
					
				case 'changefavchamp':
					$this->changeFavoriteChamp();
					break;
					
				case 'changelolcharacter':
					$this->changeLolCharacter();
					break;
					
				case 'findmybuilds':
					$this->findMyBuilds();
					break;
					
				case 'createbuild':
					$this->createBuild();
					break;
					
				case 'editbuild':
					$this->editBuild();
					break;
				
				case 'postcomment':
					$this->postComment();
					break;
					
				case 'votebuild':
					$this->voteBuild();
					break;
					
				case 'changepassword':
					$this->changePassword();
					break;
					
				case 'changemail':
					$this->changeMail();
					break;
				
				default:
				$this->ShowMain();
			}
		}
		
		/* find my builds */
		function findMyBuilds()
		{
			$db = $this->database;
			$num_rows = $db->doQuery('select b.id, b.champNum, b.writer, b.buildName, b.sefLink,
  (select count(*) from lol_build_votes where build_id=b.id and vote = 1) as positive_votes,
  (select count(*) from lol_build_votes where build_id=b.id and vote = 0) as negative_votes FROM LOL_BUILDS b WHERE b.isVisible = 1 AND writer = ? ORDER BY positive_votes DESC, b.id DESC', $_SESSION['Username']);
			if ($num_rows == -1)
			{
				$this->Error('DB_ERROR');
				$db->getError();
				return;
			}
			$content = NULL; 
			while ($row = $db->doRead())
			{
				
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
				
				$content .= Template::Load('browsebuilds_part', array('BUILD_SEF' => $row['sefLink'], 'BUILD_ID' => $row['id'], 'CHAMP_ID' => $row['champNum'], 'WRITER' => $row['writer'], 'BUILD_NAME' => $row['buildName'], 'VOTE_POSITIVE' => $positiveVotes, 'VOTE_NEGATIVE' => $negativeVotes, 'VOTE_PERCENT' => $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes))));
			}
			
			Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.findmybuilds@>');
			Template::SetVar('MY_BUILDS', $content);
			$this->content = Template::Load('account', array('ACCOUNT_PAGE_ERROR' => NULL));
		}
		
		function getPercent($num_amount, $num_total) 
		{
			if($num_total == 0)
			{
				return '<font color="green">%50</font>';
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
	
		/* change mail */
		function changeMail()
		{
			if (!isset($_POST['submit']))
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changemail@>');
				$this->content = Template::Load('account', array('ACCOUNT_PAGE_ERROR' => NULL));
			}
			else
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changemail@>');
				$this->changeMail_Process();
			}
		}
		
		function changeMail_Process()
		{
			$newmail = $this->site->SanitizeEmail($_POST['newmail']);
			$newmail_confirmation = $this->site->SanitizeEmail($_POST['cnewmail']);
			
			if(strlen($newmail) > 50)
			{
				$this->doProfileError('Girmiş olduğunuz e-mail adresi 50 karakterden uzun olamaz.');
				return;
			}
			
			if(strlen($newmail) < 10)
			{
				$this->doProfileError('Girmiş olduğunuz e-mail adresi 10 karakterden kısa olamaz.');
				return;
			}
			
			if (!preg_match("/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i", $_POST['newmail']))
			{
				$this->doProfileError('Hatalı bir e-mail girdiniz.');
				return;
			}
			
			if($newmail != $newmail_confirmation)
			{
				$this->doProfileError('Girmiş olduğunuz e-mail adresleri birbirine uymuyor.');
				return;
			}
			
			$this->site->database->doQuery('UPDATE USERDATA SET Email = ? WHERE Username = ?', $newmail, $_SESSION['Username']);
			$_SESSION['Email'] = $newmail;
			$this->doProfileSuccess('E-Mail adresin başarıyla güncellendi.');
		}
        // change mail sonu ------------------- 
		
		/* change password */
		function changePassword()
		{
			if (!isset($_POST['submit']))
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changepassword@>');
				$this->content = Template::Load('account', array('ACCOUNT_PAGE_ERROR' => NULL));
			}
			else
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changepassword@>');
				$this->changePassword_Process();
			}
		}
		
		function changePassword_Process()
		{
			$newpass = $this->site->SanitizeName($_POST['newpass']);
			$newpass_confirmation = $this->site->SanitizeName($_POST['cnewpass']);
			
			if(strlen($newpass) > 20)
			{
				$this->doProfileError('Girmiş olduğunuz şifre 20 karakterden uzun olamaz.');
				return;
			}
			
			if(strlen($newpass) < 5)
			{
				$this->doProfileError('Girmiş olduğunuz şifre 6 karakterden kısa olamaz.');
				return;
			}
			
			if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['newpass']))
			{
				$this->doProfileError('Girmiş olduğunuz şifrede özel, yada Türkçe karakterler mevcut.');
				return;
			}
			
			if($newpass != $newpass_confirmation)
			{
				$this->doProfileError('Girmiş olduğunuz şifreler birbirine uymuyor.');
				return;
			}
			
			$this->site->database->doQuery('UPDATE USERDATA SET Password = ? WHERE Username = ?', $newpass, $_SESSION['Username']);
			$_SESSION['Password'] = $newpass;
			$this->doProfileSuccess('Şifren başarıyla güncellendi.');
		}
        // change password sonu ------------------- 
		
		/* avatar */
		function changeAvatar()
		{	
			if(!isset($_POST['submit']))
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changeavatar@>');
				Template::SetVar('AVATAR_SELECTAREA', $this->getChampionAvatars());
				$this->content = Template::Load('account', array('ACCOUNT_PAGE_ERROR' => NULL));
			}
			else
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changeavatar@>');
				Template::SetVar('AVATAR_SELECTAREA', $this->getChampionAvatars());
				
				$avatarID = intval($_POST['avatar']);
				
				if($avatarID < 1)
				{
					$this->doProfileError('Avatarını seçmedin.');
					return;
				}
				
				$this->database->doQuery('UPDATE USERDATA SET avatarID = ? WHERE Username = ?', $avatarID, $_SESSION['Username']);
				$this->doProfileSuccess('Avatarın başarıyla güncellendi.');
			}
		}
		
		function getChampionAvatars()
		{
			$this->database->doQuery('SELECT Num FROM LOL_CHAMPIONS ORDER BY champName');
			$content = null;
			while($row = $this->database->doRead())
			{
				$content .= '<img src="http://www.sobafire.com/themes/default/images/lol/avatars/' . $row['Num'] . '.png" style="height: 45px; width: 45px;"></img><input type="radio" name="avatar" value="' . $row['Num'] . '">';
			}
			return $content;
		}
		// avatar sonu ------------------------
		
		/* favori şampiyon */
		function changeFavoriteChamp()
		{	
			if(!isset($_POST['submit']))
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changefavoritechamp@>');
				Template::SetVar('AVATAR_SELECTAREA', $this->getChampionAvatars());
				$this->content = Template::Load('account', array('ACCOUNT_PAGE_ERROR' => NULL));
			}
			else
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changefavoritechamp@>');
				Template::SetVar('AVATAR_SELECTAREA', $this->getChampionAvatars());
				
				$favChampID = intval($_POST['avatar']);
				
				if($favChampID < 1)
				{
					$this->doProfileError('Favori şampiyonunu seçmedin.');
					return;
				}
				
				$this->database->doQuery('UPDATE USERDATA SET favoriteChampID = ? WHERE Username = ?', $favChampID, $_SESSION['Username']);
				$this->doProfileSuccess('Favori şampiyonun başarıyla güncellendi.');
			}
		}
		// favori şampiyon sonu ------------------------
		
		/* favori şampiyon */
		function changeLolCharacter()
		{	
			if(!isset($_POST['submit']))
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changelolcharacter@>');
				$this->content = Template::Load('account', array('ACCOUNT_PAGE_ERROR' => NULL));
			}
			else
			{
				Template::SetVar('ACCOUNT_PAGE_CONTENT', '<@account.changelolcharacter@>');
				
				$summonerName = $_POST['summoner_name'];
				$serverID = intval($_POST['server']);
				$summonerName = str_replace(' ', '+', $summonerName);
				
				if(strlen($summonerName) > 30)
				{
					$this->doProfileError('Summoner adınız çok uzun.');
					return;
				}
				
				if(strlen($summonerName) < 1)
				{
					$this->doProfileError('Summoner adınız çok kısa.');
					return;
				}
				
				if($serverID > 3 || $serverID < 1)
				{
					$this->doProfileError('Sunucu seçmeyi unuttunuz.');
					return;
				}
				
				$this->database->doQuery('UPDATE USERDATA SET lolAcc = ?, lolServer = ? WHERE Username = ?', $summonerName, $serverID, $_SESSION['Username']);
				$this->doProfileSuccess('LOL karakterin başarıyla güncellendi ve profiline bağlandı.');
			}
		}
		// favori şampiyon sonu ------------------------
		
		function voteBuild()
		{
			if(!isset($_GET['vote']) || !isset($_GET['buildID']))
			{
				$this->content = Template::Load('error', array('error' => 'Bu sayfaya direkt erişim sağlayamazsınız.'));
				return;
			}
			
			$vote = intval($_GET['vote']);
			$buildID = intval($_GET['buildID']);
			
			if($vote != 0 && $vote != 1)
			{
				$this->content = Template::Load('error', array('error' => '0 ve 1 dışında oy puanı veremezsiniz.'));
				return;
			}
			
			$this->database->doQuery('SELECT count(*) as ToplamOy FROM LOL_BUILD_VOTES WHERE voter = ? AND build_id = ?', $_SESSION['Username'], $buildID);
			$row = $this->database->doRead();
			if($row['ToplamOy'] >= 1)
			{
				$this->basicError('Daha önce bu builde oy vermişsiniz.');
				return;
			}
			
			$this->database->doQuery('INSERT INTO LOL_BUILD_VOTES (vote, voter, build_id) VALUES (?, ?, ?)', $vote, $_SESSION['Username'], $buildID);
			
			//--Update Comet History
			$this->site->misc->addCometHistory($_SESSION['Username'] . ', bir builde oy verdi.');
			$this->Success('Oy başarıyla verildi.');
			
		}
		
		function postComment()
		{
			if(!isset($_POST['submit']))
			{
				$this->content = Template::Load('error', array('error' => 'Yorum göndermek için önce bir yorum yazmanız gerekir, değil mi?'));
				return;
			}
			
			if(!isset($_GET['on']))
			{
				$this->content = Template::Load('error', array('error' => 'Yorumu ne için göndereceğiniz anlaşılamadı.'));
				return;
			}
			
			//Build yorumu
			if($_GET['on'] == 'Build' && isset($_GET['buildID']))
			{
				$buildID = intval($_GET['buildID']);
				$comment = str_replace("?", "&#63;", $_POST['yorum']);
				$date = date("d.m.Y");
				
				if($buildID < 1)
				{
					$this->content = Template::Load('error', array('error' => 'Build ID\'si yanlış.'));
					return;
				}
				
				if(strlen($comment) < 3)
				{
					$this->content = Template::Load('error', array('error' => 'Girdiğiniz yorum çok kısa.'));
					return;
				}
				
				if(strlen($comment) > 950)
				{
					$this->content = Template::Load('error', array('error' => 'Girdiğiniz yorum çok uzun.'));
					return;
				}
				
				$comment = $this->site->bbcode->postBBCode($comment);
				$this->database->doQuery('INSERT INTO LOL_BUILD_COMMENTS (yorum, yorumcu, tarih, build_id) VALUES (?, ?, ?, ?)', $comment, $_SESSION['Username'], $date, $buildID);
				//--Update Comet History
				$this->site->misc->addCometHistory($_SESSION['Username'] . ', bir builde yorum yaptı.');
				$this->Success('Yorumunuz başarıyla eklendi.');
			}
			
			//haber yorumu
			if($_GET['on'] == 'News' && isset($_GET['newID']))
			{
				$newID = intval($_GET['newID']);
				$comment = str_replace("?", "&#63;", $_POST['yorum']);
				$date = date("d.m.Y");
				
				if($newID < 1)
				{
					$this->content = Template::Load('error', array('error' => 'Build ID\'si yanlış.'));
					return;
				}
				
				if(strlen($comment) < 3)
				{
					$this->content = Template::Load('error', array('error' => 'Girdiğiniz yorum çok kısa.'));
					return;
				}
				
				if(strlen($comment) > 950)
				{
					$this->content = Template::Load('error', array('error' => 'Girdiğiniz yorum çok uzun.'));
					return;
				}
				
				$this->database->doQuery('INSERT INTO LOL_HABER_COMMENTS (yorum, yorumcu, tarih, haber_id) VALUES (?, ?, ?, ?)', $comment, $_SESSION['Username'], $date, $newID);
				//--Update Comet History
				$this->site->misc->addCometHistory($_SESSION['Username'] . ', bir habere yorum yaptı.');
				$this->Success('Yorumunuz başarıyla eklendi.');
			}
		}
		
		// Build Editleme -----------------------------------------------------------------------
		
		function editBuild()
		{
			//Bu kullanıcı bu buildi editleyebilir mi?
			if(!isset($_GET['buildID']))
			{
				$this->basicError('Build ID bulunamadı.');
				return;
			}
			else
			{
				if(isset($_SESSION['Yetki']) && $_SESSION['Yetki'] == 0)
				{
					if(!isset($_GET['act']))
					{
						$this->basicError('Hangi bölümü editlemek istediğiniz anlaşılamadı.');
						return;
					}
					else
					{
						$buildID = intval($_GET['buildID']);
						$act = intval($_GET['act']);
						$this->editBuildStart($act, $buildID);
					}
				}
				else
				{
					$buildID = intval($_GET['buildID']);
					$this->site->database->doQuery('SELECT count(*) AS Toplam FROM LOL_BUILDS WHERE writer = ? AND id = ? AND isVisible = 1', $_SESSION['Username'], $buildID);
					$row = $this->database->doRead();
				
					if($row['Toplam'] < 1)
					{
						$this->basicError('Bu build size ait değil.');
						return;
					}
					else
					{
						if(!isset($_GET['act']))
						{
							$this->basicError('Hangi bölümü editlemek istediğiniz anlaşılamadı.');
							return;
						}
						else
						{
							$act = intval($_GET['act']);
							$this->editBuildStart($act, $buildID);
						}
					}
				}
			}	
		}
		
		function editBuildStart($act, $buildID)
		{
			switch($act)
			{
				case 1:
					$this->Edit_Step1($buildID);
					break;
					
				case 2:
					$this->Edit_Step2($buildID);
					break;
					
				case 3:
					$this->Edit_Step3($buildID);
					break;
					
				case 4:
					$this->Edit_Step4($buildID);
					break;
					
				case 5:
					$this->Edit_Step5($buildID);
					break;
					
				case 6:
					$this->Edit_Step6($buildID);
					break;
					
				case 7:
					$this->Edit_Step7($buildID);
					break;
					
				default:
					$this->basicError('Hangi bölümü editlemek istediğiniz anlaşılamadı.');
			}
		}
		
		// ------------------------------------------ (Edit Build Adım 1) ---------------------------------------
		function Edit_Step1($buildID)
		{
			if(!isset($_POST['submit']))
			{
				$this->Step1_showCharacters();
				Template::SetVar('BUILDEDIT_CURRENT_BUILD_NAME', $this->Edit_Step1_getCurrentBuildName($buildID));
				Template::SetVar('BUILD_ID', $buildID);
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> Build adının değiştirilmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				$this->content = Template::Load('account_editbuild.part1');
			}
			else
			{
				$this->Edit_Step1_Process($buildID);
			}
		}
		
		function Edit_Step1_Process($buildID)
		{
			$this->Step1_showCharacters();
			$build_adi = str_replace("?", "&#63;", $_POST['build_adi']);
			$champID = intval($_POST['champions']);
			
			$this->site->database->doQuery('SELECT champLowercaseName FROM LOL_CHAMPIONS WHERE Num = ?', $champID);
			$sefRow = $this->database->doRead();
			$sefLink = $this->site->misc->sefLink($sefRow['champLowercaseName'] . '-' . $build_adi);
			
			if(strlen($build_adi) >= 60)
			{
				$this->basicError('Build adı 60 karakterden uzun olamaz.');
				return;
			}
			else if(strlen($build_adi) < 1)
			{
				$this->basicError('Build adı boş bırakılamaz.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET buildName = ?, champNum = ?, sefLink = ? WHERE id = ?', $build_adi, $champID, $sefLink, $buildID);
				$this->Success('Build adı ve karakterin başarıyla değiştirildi.');
			} 
		}
		
		function Edit_Step1_getCurrentBuildName($buildID)
		{
			$this->site->database->doQuery('SELECT buildName FROM LOL_BUILDS WHERE id = ?', $buildID);
			$row = $this->site->database->doRead();
			return $row['buildName'];
		}
		
		// ------------------------------------------ (Edit Build Adım 2) ---------------------------------------
		
		function Edit_Step2($buildID)
		{
			if(!isset($_POST['submit']))
			{
				$this->Step2_showSummoners();
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> Summoner spellerin düzenlenmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				Template::SetVar('BUILD_ID', $buildID);
				$this->content = Template::Load('account_editbuild.part2');
			}
			else
			{
				$this->Edit_Step2_Process($buildID);
			}
		}
		
		function Edit_Step2_Process($buildID)
		{
			$this->Step2_showSummoners();
			$summoner1ID = intval($_POST['summoner1']);
			$summoner2ID = intval($_POST['summoner2']);
			
			if($summoner1ID == $summoner2ID)
			{	
				$this->basicError('Seçtiğiniz iki summoner skili birbirinden farklı olmalıdır.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET summoner1 = ?, summoner2 = ? WHERE id = ?', $summoner1ID, $summoner2ID, $buildID);
				$this->Success('Spellerin başarıyla değiştirildi.');
			}
		}
		
		// ------------------------------------------ (Edit Build Adım 3) ---------------------------------------
		
		function Edit_Step3($buildID)
		{
			if(!isset($_POST['submit']))
			{
				$this->Step3_showSkills();
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> Skill puanlarının dağıtılması ve düzenlenmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				Template::SetVar('BUILD_ID', $buildID);
				$this->content = Template::Load('account_editbuild.part3');
			}
			else
			{
				$this->Edit_Step3_Process($buildID);
			}
		}
		
		function Edit_Step3_Process($buildID)
		{
			$this->Step3_showSkills();
			
			for($i = 1; $i <= 18; $i++) { $skills[] = intval($_POST['skill' . $i]); }
			
			$skillsString = null;
			$qSay = null; 
			$wSay = null; 
			$eSay = null; 
			$rSay = null;
			foreach($skills as $k => $v)
			{
				$skillsString .= $v;
				if($v == 1)
				{
					$qSay++;
				}
					
				if($v == 2)
				{
					$wSay++;
				}
					
				if($v == 3)
				{
					$eSay++;
				}
					
				if($v == 4)
				{
					$rSay++;
				}
			}
			
			$this->site->database->doQuery('SELECT champNum FROM LOL_BUILDS WHERE id = ?', $buildID);
			$row = $this->database->doRead();
			$champID = $row['champNum'];
			
			// -- Skill sayısı doğru bir string mi?
			if(strlen($skillsString) != 18)
			{
				$this->basicError('Skill sayısı 18\'e eşit olmalıdır.');
				return;
			}
			
			// -- Skill sayısı (q,w,e,r sayıları) doğru mu? (Udry ve Karma hariç, onlar aşağıda.)
			else if(($qSay != 5 && $champID != 77) == true && ($qSay != 5 && $champID != 28) == true )
			{
				$this->basicError('Udyr ve Karma harici tüm karakterler en fazla 5 defa Q skiline puan verebilir.');
				return;
			}
			else if(($wSay != 5 && $champID != 77) == true && ($wSay != 5 && $champID != 28) == true )
			{
				$this->basicError('Udyr ve Karma harici tüm karakterler en fazla 5 defa W skiline puan verebilir.');
				return;
			}
			else if(($eSay != 5 && $champID != 77) == true && ($eSay != 5 && $champID != 28) == true )
			{
				$this->basicError('Udyr ve Karma harici tüm karakterler en fazla 5 defa E skiline puan verebilir.');
				return;
			}
			else if(($rSay != 3 && $champID != 77) == true && ($rSay != 5 && $champID != 28) == true )
			{
				$this->basicError('Udyr ve Karma harici tüm karakterler en fazla 3 defa R skiline puan verebilir.');
				return;
			}
			
			// -- Skill sayısı (q,w,e,r sayıları) doğru mu? [KARMA - ID: 28]
			else if($qSay != 6 && $champID == 28)
			{
				$this->basicError('Karma en fazla 6 defa Q skiline puan verebilir.');
				return;
			}
			else if($wSay != 6 && $champID == 28)
			{
				$this->basicError('Karma en fazla 6 defa W skiline puan verebilir.');
				return;
			}
			else if($eSay != 6 && $champID == 28)
			{
				$this->basicError('Karma en fazla 6 defa E skiline puan verebilir.');
				return;
			}
			else if($rSay != 0 && $champID == 28)
			{
				$this->basicError('Karma R skiline puan veremez.', 3);
				return;
			}
			
			// -- Skill sayısı (q,w,e,r sayıları) doğru mu? [UDYR - ID: 77]
			else if($qSay > 5 && $champID == 77)
			{
				$this->basicError('Udyr en fazla 5 defa Q skiline puan verebilir.');
				return;
			}
			else if($wSay > 5 && $champID == 77)
			{
				$this->basicError('Udyr en fazla 5 defa W skiline puan verebilir.');
				return;
			}
			else if($eSay > 5 && $champID == 77)
			{
				$this->basicError('Udyr en fazla 5 defa E skiline puan verebilir.');
				return;
			}
			else if($rSay > 5 && $champID == 77)
			{
				$this->basicError('Udyr en fazla 5 defa R skiline puan verebilir.');
				return;
			}
			
			// Skill puan verme sırası mantığı
			//  Level 1 ve 2'de Q ye vermemem mantığı burada yapılacak.
			
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET skillOrder = ? WHERE id = ?', $skillsString, $buildID);
				$this->Success('Skill sıralamanız başarıyla değiştirildi.');
			}
		}
		
		// ------------------------------------------ (Edit Build Adım 4) ---------------------------------------
		
		function Edit_Step4($buildID)
		{
			if(!isset($_POST['submit']))
			{
				$this->Step4_showRunes();
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> Runelerin düzenlenmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				Template::SetVar('BUILD_ID', $buildID);
				$this->content = Template::Load('account_editbuild.part4');
			}
			else
			{
				$this->Edit_Step4_Process($buildID);
			}
		}
		
		function Edit_Step4_Process($buildID)
		{
			$this->Step4_showRunes();
			
			for($i = 1; $i <= 2; $i++) { $runesQuint[] = intval($_POST['runes_quint' . $i]); $runesQuintAdet[] = intval($_POST['runes_quint' . $i . '_adet']); }
			for($i = 1; $i <= 2; $i++) { $runesMark[] = intval($_POST['runes_mark' . $i]); $runesMarkAdet[] = intval($_POST['runes_mark' . $i . '_adet']); }
			for($i = 1; $i <= 2; $i++) { $runesGlyph[] = intval($_POST['runes_glyph' . $i]); $runesGlyphAdet[] = intval($_POST['runes_glyph' . $i . '_adet']); }
			for($i = 1; $i <= 2; $i++) { $runesSeal[] = intval($_POST['runes_seal' . $i]); $runesSealAdet[] = intval($_POST['runes_seal' . $i . '_adet']); }
			
			// Rune Hesaplamaları ---------------------------------------------------------------
			// -- Rune sayıları eksi mi?
			if($runesQuintAdet[0] < 0 || $runesQuintAdet[1] < 0)
			{
				$this->basicError('Quint rune sayılarınız eksi değerde olamaz!');
				return;
			}
			else if($runesSealAdet[0] < 0 || $runesSealAdet[1] < 0)
			{
				$this->basicError('Seal rune sayılarınız eksi değerde olamaz!');
				return;
			}
			else if($runesMarkAdet[0] < 0 || $runesMarkAdet[1] < 0)
			{
				$this->basicError('Mark rune sayılarınız eksi değerde olamaz!');
				return;
			}
			else if($runesGlyphAdet[0] < 0 || $runesGlyphAdet[1] < 0)
			{
				$this->basicError('Glyph rune sayılarınız eksi değerde olamaz!');
				return;
			}
			
			// -- Rune seçmeyip adet girdik mi?
			else if($runesQuint[0] == 0 || $runesSeal[0] == 0 || $runesGlyph[0] == 0 || $runesQuint[0] == 0)
			{
				$this->basicError('Seçmediğiniz bazı runeler var.');
				return;
			}
			else if($runesQuint[1] == 0 && $runesQuintAdet[1] != 0)
			{
				$this->basicError('İkinci Quint runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			else if($runesSeal[1] == 0 && $runesSealAdet[1] != 0)
			{
				$this->basicError('İkinci Seal runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			else if($runesGlyph[1] == 0 && $runesGlyphAdet[1] != 0)
			{
				$this->basicError('İkinci Glyph runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			else if($runesMark[1] == 0 && $runesMarkAdet[1] != 0)
			{
				$this->basicError('İkinci Mark runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			
			// -- Tekli rune sayıları 9 yada 3'den fazla mı?
			else if($runesQuintAdet[0] > 3 || $runesQuintAdet[0] < 0 || $runesQuintAdet[1] > 3 || $runesQuintAdet[1] < 0)
			{
				$this->basicError('Quintler en fazla 3 tane olabilir.');
				return;
			}
			else if($runesSealAdet[0] > 9 || $runesSealAdet[0] < 0 || $runesSealAdet[1] > 9 || $runesSealAdet[1] < 0)
			{
				$this->basicError('Sealler en fazla 9 tane olabilir.');
				return;
			}
			else if($runesGlyphAdet[0] > 9 || $runesGlyphAdet[0] < 0 || $runesGlyphAdet[1] >= 9 || $runesGlyphAdet[1] < 0)
			{
				$this->basicError('Glyphler en fazla 9 tane olabilir.');
				return;
			}
			else if($runesMarkAdet[0] > 9 || $runesMarkAdet[0] < 0 || $runesMarkAdet[1] >= 9 || $runesMarkAdet[1] < 0)
			{
				$this->basicError('Marklar en fazla 9 tane olabilir.');
				return;
			}
			
			// -- İki rune sayısının toplamı 9 yada 3'den fazla mı?
			else if(($runesQuintAdet[0] + $runesQuintAdet[1]) != 3)
			{
				$this->basicError('2 tane Quint runesinin toplamı 3\'e eşit olmalıdır.');
				return;
			}
			else if(($runesMarkAdet[0] + $runesMarkAdet[1]) != 9)
			{
				$this->basicError('2 tane Mark runesinin toplamı 9\'a eşit olmalıdır.');
				return;
			}
			else if(($runesGlyphAdet[0] + $runesGlyphAdet[1]) != 9)
			{
				$this->basicError('2 tane Glyph runesinin toplamı 9\'a eşit olmalıdır.');
				return;
			}
			else if(($runesSealAdet[0] + $runesSealAdet[1]) != 9)
			{
				$this->basicError('2 tane Seal runesinin toplamı 9\'a eşit olmalıdır.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET runeMark1 = ?, runeMark1Adet = ?, runeMark2 = ?, runeMark2Adet = ?, runeSeal1 = ?, runeSeal1Adet = ?, runeSeal2 = ?, runeSeal2Adet = ?, runeQuint1 = ?, runeQuint1Adet = ?, runeQuint2 = ?, runeQuint2Adet = ?, runeGlyph1 = ?, runeGlyph1Adet = ?, runeGlyph2 = ?, runeGlyph2Adet = ? WHERE id = ?', $runesMark[0], $runesMarkAdet[0], $runesMark[1], $runesMarkAdet[1], $runesSeal[0], $runesSealAdet[0], $runesSeal[1], $runesSealAdet[1], $runesQuint[0],$runesQuintAdet[0], $runesQuint[1], $runesQuintAdet[1], $runesGlyph[0], $runesGlyphAdet[0], $runesGlyph[1], $runesGlyphAdet[1], $buildID);
				$this->Success('Runeleriniz başarıyla değiştirildi.');
			}
		}
		
		// ------------------------------------------ (Edit Build Adım 5) ---------------------------------------
		
		function Edit_Step5($buildID)
		{
			if(!isset($_POST['submit']))
			{
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> Masterylerin düzenlenmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				Template::SetVar('BUILD_ID', $buildID);
				$this->content = Template::Load('account_editbuild.part5');
			}
			else
			{
				$this->Edit_Step5_Process($buildID);
			}
		}
		
		function Edit_Step5_Process($buildID)
		{
			$masteryNum = $_POST['mastery_num'];
			$masteryNumArray = explode(',', $masteryNum);
			$masteryNumTotal = 0;
			foreach($masteryNumArray as $k => $v)
			{
				$masteryNumTotal += $v;
			}
	
			if($masteryNumTotal != 30)
			{
				$this->basicError('Masterylerde 30 puanı doğru dağıtmadınız.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET masteryNum = ? WHERE id = ?', $masteryNum, $buildID);
				$this->Success('Masteryleriniz başarıyla değiştirildi.');
			}
		}
		
		// ------------------------------------------ (Edit Build Adım 6) ---------------------------------------
		
		function Edit_Step6($buildID)
		{
			if(!isset($_POST['submit']))
			{
				$this->Step6_showItems();
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> İtemlerin düzenlenmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				Template::SetVar('BUILD_ID', $buildID);
				$this->content = Template::Load('account_editbuild.part6');
			}
			else
			{
				$this->Edit_Step6_Process($buildID);
			}
		}
		
		function Edit_Step6_Process($buildID)
		{
			$this->Step6_showItems();
			
			for($i = 1; $i <= 6; $i++) { $itemsEarly[] = intval($_POST['item_early' . $i]); }
			for($i = 1; $i <= 6; $i++) { $itemsMid[] = intval($_POST['item_mid' . $i]); }
			for($i = 1; $i <= 6; $i++) { $itemsLate[] = intval($_POST['item_late' . $i]); }
			
			//string prepare
			$itemsEarlyString = null;
			foreach($itemsEarly as $k => $v)
			{
				$itemsEarlyString .= $v . ',';
			}
			
			$itemsMidString = null;
			foreach($itemsMid as $k => $v)
			{
				$itemsMidString .= $v . ',';
			}
			
			$itemsLateString = null;
			foreach($itemsLate as $k => $v)
			{
				$itemsLateString .= $v . ',';
			}
			
			//item fiyatları
			$itemsEarlyTotalPrice = 0;
			foreach($itemsEarly as $k => $v)
			{
				$this->database->doQuery('SELECT item_toplamfiyat FROM LOL_ITEMS WHERE item_id = ?', $v);
				$row = $this->database->doRead();
				$itemsEarlyTotalPrice += $row['item_toplamfiyat'];
			}
			
			$itemsMidTotalPrice = 0;
			foreach($itemsMid as $k => $v)
			{
				$this->database->doQuery('SELECT item_toplamfiyat FROM LOL_ITEMS WHERE item_id = ?', $v);
				$row = $this->database->doRead();
				$itemsMidTotalPrice += $row['item_toplamfiyat'];
			}
			
			$itemsLateTotalPrice = 0;
			foreach($itemsLate as $k => $v)
			{
				$this->database->doQuery('SELECT item_toplamfiyat FROM LOL_ITEMS WHERE item_id = ?', $v);
				$row = $this->database->doRead();
				$itemsLateTotalPrice += $row['item_toplamfiyat'];
			}
			
			// İtem Kontrolleri ---------------------------------------------------------------
			//--İtemler (early)
			if($itemsEarlyTotalPrice > 515)
			{
				$this->basicError('Oyun başında en fazla <b>515 gold</b> değerinde item seçebilirsiniz. Sizin seçtiğiniz itemlerin değeri: <b>' . $itemsEarlyTotalPrice . ' gold</b>');
				return;
			}
			else if ($itemsEarlyTotalPrice < 1)
			{
				$this->basicError('Oyun başında itemsiz başlayamazsınız.');
				return;
			}
			
			//--İtemler (mid)
			else if ($itemsMidTotalPrice < 1)
			{
				$this->basicError('Oyun ortasında itemsiz devam edemezsiniz.');
				return;
			}
			
			//--İtemler (late)
			else if ($itemsLateTotalPrice < 1)
			{
				$this->basicError('Oyun sonunda itemsiz devam edemezsiniz.');
				return;
			}
			
			$this->database->doQuery('UPDATE LOL_BUILDS SET earlyItemsOrder = ?, midItemsOrder = ?, lateItemsOrder = ? WHERE id = ?', $itemsEarlyString, $itemsMidString, $itemsLateString, $buildID);
			$this->Success('İtemleriniz başarıyla değiştirildi.');
			
		}
		
		// ------------------------------------------ (Edit Build Adım 7) ---------------------------------------
		
		function Edit_Step7($buildID)
		{
			if(!isset($_POST['submit']))
			{
				Template::SetVar('ACCOUNT_EDITBUILD_ICERIK1_VALUE', $this->Edit_Step7_getIcerik(1, $buildID));
				Template::SetVar('ACCOUNT_EDITBUILD_ICERIK2_VALUE', $this->Edit_Step7_getIcerik(2, $buildID));
				Template::SetVar('ACCOUNT_EDITBUILD_ICERIK3_VALUE', $this->Edit_Step7_getIcerik(3, $buildID));
				
				Template::SetVar('infoarea', '<@account_editbuild.infoarea@>');
				Template::SetVar('info', '<b>Build Düzenleme:</b> İçerik yazılarının düzenlenmesi.<br>Düzenleme yapmak istemiyorsanız <b>geri dönün.</b>');
				Template::SetVar('hata', null);
				Template::SetVar('BUILD_ID', $buildID);
				$this->content = Template::Load('account_editbuild.part7');
			}
			else
			{
				$this->Edit_Step7_Process($buildID);
			}
		}
		
		function Edit_Step7_Process($buildID)
		{
			$icerik1 = $_POST['icerik1'];
			$icerik1 = $this->site->bbcode->postBBCode($icerik1);
			$icerik1_bbcode = str_replace('?', '&#63;', $_POST['icerik1']);

			$icerik2 = $_POST['icerik2'];
			$icerik2 = $this->site->bbcode->postBBCode($icerik2);
			$icerik2_bbcode = str_replace('?', '&#63;', $_POST['icerik2']);
			
			$icerik3 = $_POST['icerik3'];
			$icerik3 = $this->site->bbcode->postBBCode($icerik3);
			$icerik3_bbcode = str_replace('?', '&#63;', $_POST['icerik3']);
			
			//içerik yazılarının kontrolü
			
			if(strlen($icerik1) < 10)
			{
				$this->basicError('1. içerik yazısı çok kısa.');
				return;
			}
			
			if(strlen($icerik2) < 10)
			{
				$this->basicError('2. içerik yazısı çok kısa.');
				return;
			}
			
			if(strlen($icerik3) < 10)
			{
				$this->basicError('3. içerik yazısı çok kısa.');
				return;
			}
			
			$this->database->doQuery('UPDATE LOL_BUILDS SET icerik1 = ?, icerik2 = ?, icerik3 = ?, icerik1_bbcode = ?, icerik2_bbcode = ?, icerik3_bbcode = ? WHERE id = ?', $icerik1, $icerik2, $icerik3, $icerik1_bbcode, $icerik2_bbcode, $icerik3_bbcode, $buildID);
			$this->Success('İçerik yazıların başarıyla güncellendi.');
		}
		
		function Edit_Step7_getIcerik($icerikID, $buildID)
		{
			switch($icerikID)
			{
				case 1:
					$this->site->database->doQuery('SELECT icerik1_bbcode FROM LOL_BUILDS WHERE id = ?', $buildID);
					$row = $this->database->doRead();
					return str_replace('<br />', '', $row['icerik1_bbcode']);
					break;
				
				case 2:
					$this->site->database->doQuery('SELECT icerik2_bbcode FROM LOL_BUILDS WHERE id = ?', $buildID);
					$row = $this->database->doRead();
					return str_replace('<br />', '', $row['icerik2_bbcode']);
					break;
					
				case 3:
					$this->site->database->doQuery('SELECT icerik3_bbcode FROM LOL_BUILDS WHERE id = ?', $buildID);
					$row = $this->database->doRead();
					return str_replace('<br />', '', $row['icerik3_bbcode']);
					break;
			}
		}
		
		// Build Oluşturma ----------------------------------------------------------------------
		function createBuild()
		{
			if(!isset($_SESSION['Step1Passed']) && $_SESSION['Step1Passed'] == FALSE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step1() : $this->Step1_Process();
			}
			else if(!isset($_SESSION['Step2Passed']) && $_SESSION['Step1Passed'] == TRUE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step2() : $this->Step2_Process();
			}
			else if(!isset($_SESSION['Step3Passed']) && $_SESSION['Step2Passed'] == TRUE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step3() : $this->Step3_Process();
			}
			else if(!isset($_SESSION['Step4Passed']) && $_SESSION['Step3Passed'] == TRUE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step4() : $this->Step4_Process();
			}
			else if(!isset($_SESSION['Step5Passed']) && $_SESSION['Step4Passed'] == TRUE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step5() : $this->Step5_Process();
			}
			else if(!isset($_SESSION['Step6Passed']) && $_SESSION['Step5Passed'] == TRUE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step6() : $this->Step6_Process();
			}
			else if(!isset($_SESSION['Step7Passed']) && $_SESSION['Step6Passed'] == TRUE)
			{
				($_SERVER['REQUEST_METHOD'] != 'POST') ? $this->Step7() : $this->Step7_Process();
			}
			else if(!isset($_SESSION['Step8Passed']) && $_SESSION['Step7Passed'] == TRUE)
			{
				$this->Step8(); //final output
			}
			else
			{
				//hata göster
			}
		}
		
		// ------------------------------------------ (Step 1) ----------------------------------------------
		function Step1()
		{
			$this->Step1_showCharacters();
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 1/7:</b> Build adının girilmesi ve karakterin seçilmesi.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part1');
		}
		
		function Step1_Process()
		{
			$this->Step1_showCharacters();
			$build_adi = str_replace("?", "&#63;", $_POST['build_adi']);
			$champID = intval($_POST['champions']);
			
			$this->site->database->doQuery('SELECT champLowercaseName FROM LOL_CHAMPIONS WHERE Num = ?', $champID);
			$sefRow = $this->database->doRead();
			$sefLink = $this->site->misc->sefLink($sefRow['champLowercaseName'] . '-' . $build_adi);
			
			if(strlen($build_adi) >= 60)
			{
				$this->doBuildErrorAjax('Build adı 60 karakterden uzun olamaz.');
				return;
			}
			else if(strlen($build_adi) < 1)
			{
				$this->doBuildErrorAjax('Build adı boş bırakılamaz.');
				return;
			}
			else
			{
				$this->database->doQuery('INSERT INTO LOL_BUILDS 
					(champNum, writer, buildName, votePositive, voteNegative, summoner1, summoner2, runeMark1, runeMark1Adet, runeMark2, runeMark2Adet, runeSeal1, runeSeal1Adet, runeSeal2, runeSeal2Adet, runeQuint1, runeQuint1Adet, runeQuint2, runeQuint2Adet, runeGlyph1, runeGlyph1Adet, runeGlyph2, runeGlyph2Adet, skillOrder, earlyItemsOrder, midItemsOrder, lateItemsOrder, icerik1, icerik2, icerik3, icerik1_bbcode, icerik2_bbcode, icerik3_bbcode, masteryNum, isVisible, sefLink, timestamp) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', $champID, $_SESSION['Username'], $build_adi, 1, 1, 0, 0, 0, 0, 0, 0, 0,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,0, 0, 0, 0,0,0, 0,0,0, 0, $sefLink, time());
				
				$this->database->doQuery('SELECT * FROM LOL_BUILDS WHERE writer = ? AND isVisible = 0 ORDER BY id DESC', $_SESSION['Username']);
				$row = $this->database->doRead();
				$buildID = $row['id'];
				
				$_SESSION['Step1Passed'] = TRUE;
				$_SESSION['buildID'] = $buildID;
				$_SESSION['champID'] = $champID;
				
				$this->doBuildErrorAjax('success');
			}
		}
		
		function Step1_showCharacters()
		{
			$this->database->doQuery('SELECT * FROM LOL_CHAMPIONS ORDER BY champName');
			$champdata = null;
			while($row = $this->database->doRead())
			{
				$champdata .= '<option value="' . $row['Num'] . '">' . $row['champName'] . '</option>';
			}
			Template::SetVar('SELECT_CHARACTERS', $champdata);
		}
		
		// ------------------------------------------ (Step 2) ----------------------------------------------
		
		function Step2()
		{
			$this->Step2_showSummoners();
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 2/7:</b> Büyülerin (Summoner Spells) seçilmesi.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part2');
		}
		
		function Step2_Process()
		{
			$this->Step2_showSummoners();
			$summoner1ID = intval($_POST['summoner1']);
			$summoner2ID = intval($_POST['summoner2']);
			
			if($summoner1ID == $summoner2ID)
			{	
				$this->doBuildErrorAjax('Seçtiğiniz iki summoner skili birbirinden farklı olmalıdır.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET summoner1 = ?, summoner2 = ? WHERE id = ? AND writer = ?', $summoner1ID, $summoner2ID, $_SESSION['buildID'], $_SESSION['Username']);
				
				$_SESSION['Step2Passed'] = TRUE;
				$this->doBuildErrorAjax('success');
			}
		}
		
		function Step2_showSummoners()
		{
			$this->database->doQuery('SELECT * FROM LOL_SUMMONERS ORDER BY summoner_name');
			$summonerdata = null;
			while($row = $this->database->doRead())
			{
				$summonerdata .= '<option value="' . $row['id'] . '">' . $row['summoner_name'] . '</option>';
			}
			Template::SetVar('SELECT_SUMMONERS', $summonerdata);
		}
		
		// ------------------------------------------ (Step 3) ----------------------------------------------
		
		function Step3()
		{
			$this->Step3_showSkills();
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 3/7:</b> Skill puanlarının dağıtılması.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part3');
		}
		
		function Step3_Process()
		{
			$this->Step3_showSkills();
			
			for($i = 1; $i <= 18; $i++) { $skills[] = intval($_POST['skill' . $i]); }
			
			$skillsString = null;
			$qSay = null; 
			$wSay = null; 
			$eSay = null; 
			$rSay = null;
			foreach($skills as $k => $v)
			{
				$skillsString .= $v;
				if($v == 1)
				{
					$qSay++;
				}
					
				if($v == 2)
				{
					$wSay++;
				}
					
				if($v == 3)
				{
					$eSay++;
				}
					
				if($v == 4)
				{
					$rSay++;
				}
			}
			
			// -- Skill sayısı doğru bir string mi?
			if(strlen($skillsString) != 18)
			{
				$this->doBuildErrorAjax('Skill sayısı 18\'e eşit olmalıdır.');
				return;
			}
			
			// -- Skill sayısı (q,w,e,r sayıları) doğru mu? (Udry ve Karma hariç, onlar aşağıda.)
			else if(($qSay != 5 && $_SESSION['champID'] != 77) == true && ($qSay != 5 && $_SESSION['champID'] != 28) == true )
			{
				$this->doBuildErrorAjax('Udyr ve Karma harici tüm karakterler en fazla 5 defa Q skiline puan verebilir.');
				return;
			}
			else if(($wSay != 5 && $_SESSION['champID'] != 77) == true && ($wSay != 5 && $_SESSION['champID'] != 28) == true )
			{
				$this->doBuildErrorAjax('Udyr ve Karma harici tüm karakterler en fazla 5 defa W skiline puan verebilir.');
				return;
			}
			else if(($eSay != 5 && $_SESSION['champID'] != 77) == true && ($eSay != 5 && $_SESSION['champID'] != 28) == true )
			{
				$this->doBuildErrorAjax('Udyr ve Karma harici tüm karakterler en fazla 5 defa E skiline puan verebilir.');
				return;
			}
			else if(($rSay != 3 && $_SESSION['champID'] != 77) == true && ($rSay != 5 && $_SESSION['champID'] != 28) == true )
			{
				$this->doBuildErrorAjax('Udyr ve Karma harici tüm karakterler en fazla 3 defa R skiline puan verebilir.');
				return;
			}
			
			// -- Skill sayısı (q,w,e,r sayıları) doğru mu? [KARMA - ID: 28]
			else if($qSay != 6 && $_SESSION['champID'] == 28)
			{
				$this->doBuildErrorAjax('Karma en fazla 6 defa Q skiline puan verebilir.');
				return;
			}
			else if($wSay != 6 && $_SESSION['champID'] == 28)
			{
				$this->doBuildErrorAjax('Karma en fazla 6 defa W skiline puan verebilir.');
				return;
			}
			else if($eSay != 6 && $_SESSION['champID'] == 28)
			{
				$this->doBuildErrorAjax('Karma en fazla 6 defa E skiline puan verebilir.');
				return;
			}
			else if($rSay != 0 && $_SESSION['champID'] == 28)
			{
				$this->doBuildErrorAjax('Karma R skiline puan veremez.');
				return;
			}
			
			// -- Skill sayısı (q,w,e,r sayıları) doğru mu? [UDYR - ID: 77]
			else if($qSay > 5 && $_SESSION['champID'] == 77)
			{
				$this->doBuildErrorAjax('Udyr en fazla 5 defa Q skiline puan verebilir.');
				return;
			}
			else if($wSay > 5 && $_SESSION['champID'] == 77)
			{
				$this->doBuildErrorAjax('Udyr en fazla 5 defa W skiline puan verebilir.');
				return;
			}
			else if($eSay > 5 && $_SESSION['champID'] == 77)
			{
				$this->doBuildErrorAjax('Udyr en fazla 5 defa E skiline puan verebilir.');
				return;
			}
			else if($rSay > 5 && $_SESSION['champID'] == 77)
			{
				$this->doBuildErrorAjax('Udyr en fazla 5 defa R skiline puan verebilir.');
				return;
			}
			
			// Skill puan verme sırası mantığı
			//  Level 1 ve 2'de Q ye vermemem mantığı burada yapılacak.
			
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET skillOrder = ? WHERE id = ? AND writer = ?', $skillsString, $_SESSION['buildID'], $_SESSION['Username']);
				
				$_SESSION['Step3Passed'] = TRUE;
				$this->doBuildErrorAjax('success');
			}
		}
		
		function Step3_showSkills()
		{
			$skilldata = null;
			for($i = 1; $i <= 18; $i++)
			{
				$skilldata .= $i . '. skill: <select name="skill' . $i . '">
											 <option value="1">Q</option>
											 <option value="2">W</option>
											 <option value="3">E</option>
											<option value="4">R</option>
											</select><br>';
			}
			Template::SetVar('SELECT_SKILLS', $skilldata);
		}
		
		// ------------------------------------------ (Step 4) ----------------------------------------------
		
		function Step4()
		{
			$this->Step4_showRunes();
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 4/7:</b> Runelerin ayarlanması.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part4');
		}
		
		function Step4_Process()
		{
			$this->Step4_showRunes();
			
			for($i = 1; $i <= 2; $i++) { $runesQuint[] = intval($_POST['runes_quint' . $i]); $runesQuintAdet[] = intval($_POST['runes_quint' . $i . '_adet']); }
			for($i = 1; $i <= 2; $i++) { $runesMark[] = intval($_POST['runes_mark' . $i]); $runesMarkAdet[] = intval($_POST['runes_mark' . $i . '_adet']); }
			for($i = 1; $i <= 2; $i++) { $runesGlyph[] = intval($_POST['runes_glyph' . $i]); $runesGlyphAdet[] = intval($_POST['runes_glyph' . $i . '_adet']); }
			for($i = 1; $i <= 2; $i++) { $runesSeal[] = intval($_POST['runes_seal' . $i]); $runesSealAdet[] = intval($_POST['runes_seal' . $i . '_adet']); }
			
			// Rune Hesaplamaları ---------------------------------------------------------------
			// -- Rune sayıları eksi mi?
			if($runesQuintAdet[0] < 0 || $runesQuintAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Quint rune sayılarınız eksi değerde olamaz!');
				return;
			}
			else if($runesSealAdet[0] < 0 || $runesSealAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Seal rune sayılarınız eksi değerde olamaz!');
				return;
			}
			else if($runesMarkAdet[0] < 0 || $runesMarkAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Mark rune sayılarınız eksi değerde olamaz!');
				return;
			}
			else if($runesGlyphAdet[0] < 0 || $runesGlyphAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Glyph rune sayılarınız eksi değerde olamaz!');
				return;
			}
			
			// -- Rune seçmeyip adet girdik mi?
			else if($runesQuint[0] == 0 || $runesSeal[0] == 0 || $runesGlyph[0] == 0 || $runesQuint[0] == 0)
			{
				$this->doBuildErrorAjax('Seçmediğiniz bazı runeler var.');
				return;
			}
			else if($runesQuint[1] == 0 && $runesQuintAdet[1] != 0)
			{
				$this->doBuildErrorAjax('İkinci Quint runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			else if($runesSeal[1] == 0 && $runesSealAdet[1] != 0)
			{
				$this->doBuildErrorAjax('İkinci Seal runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			else if($runesGlyph[1] == 0 && $runesGlyphAdet[1] != 0)
			{
				$this->doBuildErrorAjax('İkinci Glyph runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			else if($runesMark[1] == 0 && $runesMarkAdet[1] != 0)
			{
				$this->doBuildErrorAjax('İkinci Mark runenizi boş bırakacaksanız adet girmeyiniz.');
				return;
			}
			
			// -- Tekli rune sayıları 9 yada 3'den fazla mı?
			else if($runesQuintAdet[0] > 3 || $runesQuintAdet[0] < 0 || $runesQuintAdet[1] > 3 || $runesQuintAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Quintler en fazla 3 tane olabilir.');
				return;
			}
			else if($runesSealAdet[0] > 9 || $runesSealAdet[0] < 0 || $runesSealAdet[1] > 9 || $runesSealAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Sealler en fazla 9 tane olabilir.');
				return;
			}
			else if($runesGlyphAdet[0] > 9 || $runesGlyphAdet[0] < 0 || $runesGlyphAdet[1] >= 9 || $runesGlyphAdet[1] < 0)
			{
					$this->doBuildErrorAjax('Glyphler en fazla 9 tane olabilir.');
					return;
			}
			else if($runesMarkAdet[0] > 9 || $runesMarkAdet[0] < 0 || $runesMarkAdet[1] >= 9 || $runesMarkAdet[1] < 0)
			{
				$this->doBuildErrorAjax('Marklar en fazla 9 tane olabilir.');
				return;
			}
			
			// -- İki rune sayısının toplamı 9 yada 3'den fazla mı?
			else if(($runesQuintAdet[0] + $runesQuintAdet[1]) != 3)
			{
				$this->doBuildErrorAjax('2 tane Quint runesinin toplamı 3\'e eşit olmalıdır.');
				return;
			}
			else if(($runesMarkAdet[0] + $runesMarkAdet[1]) != 9)
			{
				$this->doBuildErrorAjax('2 tane Mark runesinin toplamı 9\'a eşit olmalıdır.');
				return;
			}
			else if(($runesGlyphAdet[0] + $runesGlyphAdet[1]) != 9)
			{
				$this->doBuildErrorAjax('2 tane Glyph runesinin toplamı 9\'a eşit olmalıdır.');
				return;
			}
			else if(($runesSealAdet[0] + $runesSealAdet[1]) != 9)
			{
				$this->doBuildErrorAjax('2 tane Seal runesinin toplamı 9\'a eşit olmalıdır.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET runeMark1 = ?, runeMark1Adet = ?, runeMark2 = ?, runeMark2Adet = ?, runeSeal1 = ?, runeSeal1Adet = ?, runeSeal2 = ?, runeSeal2Adet = ?, runeQuint1 = ?, runeQuint1Adet = ?, runeQuint2 = ?, runeQuint2Adet = ?, runeGlyph1 = ?, runeGlyph1Adet = ?, runeGlyph2 = ?, runeGlyph2Adet = ? WHERE id = ? AND writer = ?', $runesMark[0], $runesMarkAdet[0], $runesMark[1], $runesMarkAdet[1], $runesSeal[0], $runesSealAdet[0], $runesSeal[1], $runesSealAdet[1], $runesQuint[0],$runesQuintAdet[0], $runesQuint[1], $runesQuintAdet[1], $runesGlyph[0], $runesGlyphAdet[0], $runesGlyph[1], $runesGlyphAdet[1], $_SESSION['buildID'], $_SESSION['Username']);
				
				$_SESSION['Step4Passed'] = TRUE;
				$this->doBuildErrorAjax('success');
			}
		}
		
		function Step4_showRunes()
		{
			$this->database->doQuery('SELECT * FROM LOL_RUNES');
			$runesQuintdata = null;
			$runesSealdata = null;
			$runesMarkdata = null;
			$runesGlyphdata = null;
			while($row = $this->database->doRead())
			{
				if ($row['type'] == 'MARK') {
					$runesMarkdata .= '<option value="' . $row['id'] . '">' . $row['rune_name'] . '</option>'; }
				else if ($row['type'] == 'QUINT') {
					$runesQuintdata .= '<option value="' . $row['id'] . '">' . $row['rune_name'] . '</option>'; }
				else if ($row['type'] == 'SEAL') {
					$runesSealdata .= '<option value="' . $row['id'] . '">' . $row['rune_name'] . '</option>'; }
				else {
					$runesGlyphdata .= '<option value="' . $row['id'] . '">' . $row['rune_name'] . '</option>'; }
			}
			
			Template::SetVar('SELECT_RUNES_MARK', $runesMarkdata);
			Template::SetVar('SELECT_RUNES_QUINT', $runesQuintdata);
			Template::SetVar('SELECT_RUNES_SEAL', $runesSealdata);
			Template::SetVar('SELECT_RUNES_GLYPH', $runesGlyphdata);
		}
		
		// ------------------------------------------ (Step 5) ----------------------------------------------
		
		function Step5()
		{
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 5/7:</b> Masterylerin ayarlanması.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part5');
		}
		
		function Step5_Process()
		{
			$masteryNum = $_POST['mastery_num'];
			$masteryNumArray = explode(',', $masteryNum);
			$masteryNumTotal = 0;
			foreach($masteryNumArray as $k => $v)
			{
				$masteryNumTotal += $v;
			}
	
			if($masteryNumTotal != 30)
			{
				$this->doBuildErrorAjax('Masterylerde 30 puanı doğru dağıtmadınız.');
				return;
			}
			else
			{
				$this->database->doQuery('UPDATE LOL_BUILDS SET masteryNum = ? WHERE id = ? AND writer = ?', $masteryNum, $_SESSION['buildID'], $_SESSION['Username']);
				$_SESSION['Step5Passed'] = TRUE;
				$this->doBuildErrorAjax('success');
			}
		}
		
		// ------------------------------------------ (Step 6) ----------------------------------------------
		
		function Step6()
		{
			$this->Step6_showItems();
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 6/7:</b> Early, mid ve late game itemlerinin eklenmesi.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part6');
		}
		
		function Step6_Process()
		{
			$this->Step6_showItems();
			
			for($i = 1; $i <= 6; $i++) { $itemsEarly[] = intval($_POST['item_early' . $i]); }
			for($i = 1; $i <= 6; $i++) { $itemsMid[] = intval($_POST['item_mid' . $i]); }
			for($i = 1; $i <= 6; $i++) { $itemsLate[] = intval($_POST['item_late' . $i]); }
			
			//string prepare
			$itemsEarlyString = null;
			foreach($itemsEarly as $k => $v)
			{
				$itemsEarlyString .= $v . ',';
			}
			
			$itemsMidString = null;
			foreach($itemsMid as $k => $v)
			{
				$itemsMidString .= $v . ',';
			}
			
			$itemsLateString = null;
			foreach($itemsLate as $k => $v)
			{
				$itemsLateString .= $v . ',';
			}
			
			//item fiyatları
			$itemsEarlyTotalPrice = 0;
			foreach($itemsEarly as $k => $v)
			{
				$this->database->doQuery('SELECT item_toplamfiyat FROM LOL_ITEMS WHERE item_id = ?', $v);
				$row = $this->database->doRead();
				$itemsEarlyTotalPrice += $row['item_toplamfiyat'];
			}
			
			$itemsMidTotalPrice = 0;
			foreach($itemsMid as $k => $v)
			{
				$this->database->doQuery('SELECT item_toplamfiyat FROM LOL_ITEMS WHERE item_id = ?', $v);
				$row = $this->database->doRead();
				$itemsMidTotalPrice += $row['item_toplamfiyat'];
			}
			
			$itemsLateTotalPrice = 0;
			foreach($itemsLate as $k => $v)
			{
				$this->database->doQuery('SELECT item_toplamfiyat FROM LOL_ITEMS WHERE item_id = ?', $v);
				$row = $this->database->doRead();
				$itemsLateTotalPrice += $row['item_toplamfiyat'];
			}
			
			// İtem Kontrolleri ---------------------------------------------------------------
			//--İtemler (early)
			if($itemsEarlyTotalPrice > 515)
			{
				$this->doBuildErrorAjax('Oyun başında en fazla <b>515 gold</b> değerinde item seçebilirsiniz. Sizin seçtiğiniz itemlerin değeri: <b>' . $itemsEarlyTotalPrice . ' gold</b>');
				return;
			}
			else if ($itemsEarlyTotalPrice < 1)
			{
				$this->doBuildErrorAjax('Oyun başında itemsiz başlayamazsınız.');
				return;
			}
			
			//--İtemler (mid)
			else if ($itemsMidTotalPrice < 1)
			{
				$this->doBuildErrorAjax('Oyun ortasında itemsiz devam edemezsiniz.');
				return;
			}
			
			//--İtemler (late)
			else if ($itemsLateTotalPrice < 1)
			{
				$this->doBuildErrorAjax('Oyun sonunda itemsiz devam edemezsiniz.');
				return;
			}
			
			$this->database->doQuery('UPDATE LOL_BUILDS SET earlyItemsOrder = ?, midItemsOrder = ?, lateItemsOrder = ? WHERE id = ? AND writer = ?', $itemsEarlyString, $itemsMidString, $itemsLateString, $_SESSION['buildID'], $_SESSION['Username']);
			$_SESSION['Step6Passed'] = TRUE;
			$this->doBuildErrorAjax('success');
			
		}
		
		function Step6_showItems()
		{
			$this->database->doQuery('SELECT * FROM LOL_ITEMS WHERE item_toplamfiyat < 491 ORDER BY item_adi');
			$itemdataEarly = null;
			while($row = $this->database->doRead())
			{
				$itemdataEarly .= '<option value="' . $row['item_id'] . '">' . $row['item_adi'] . '</option>';
			}
			Template::SetVar('SELECT_ITEMS_EARLY', $itemdataEarly);
			
			//itemler
			$this->database->doQuery('SELECT * FROM LOL_ITEMS ORDER BY item_adi');
			$itemdata = null;
			while($row = $this->database->doRead())
			{
				$itemdata .= '<option value="' . $row['item_id'] . '">' . $row['item_adi'] . '</option>';
			}
			Template::SetVar('SELECT_ITEMS', $itemdata);
		}
		// ------------------------------------------ (Step 6) ----------------------------------------------
		
		function Step7()
		{
			$this->Step6_showItems();
			Template::SetVar('infoarea', '<@account_createbuild.infoarea@>');
			Template::SetVar('info', '<b>Adım 7/7:</b> İçerik yazılarının yazılması.');
			Template::SetVar('hata', null);
			$this->content = Template::Load('account_createbuild.part7');
		}
		
		function Step7_Process()
		{
			$icerik1 = $_POST['icerik1'];
			$icerik1 = $this->site->bbcode->postBBCode($icerik1);
			$icerik1_bbcode = str_replace('?', '&#63;', $_POST['icerik1']);
			
			$icerik2 = $_POST['icerik2'];
			$icerik2 = $this->site->bbcode->postBBCode($icerik2);
			$icerik2_bbcode = str_replace('?', '&#63;', $_POST['icerik2']);
			
			$icerik3 = $_POST['icerik3'];
			$icerik3 = $this->site->bbcode->postBBCode($icerik3);
			$icerik3_bbcode = str_replace('?', '&#63;', $_POST['icerik3']);
			
			//içerik yazılarının kontrolü
			
			if(strlen($icerik1) < 10)
			{
				$this->doBuildErrorAjax('1. içerik yazısı çok kısa.');
				return;
			}
			
			if(strlen($icerik2) < 10)
			{
				$this->doBuildErrorAjax('2. içerik yazısı çok kısa.');
				return;
			}
			
			if(strlen($icerik3) < 10)
			{
				$this->doBuildErrorAjax('3. içerik yazısı çok kısa.');
				return;
			}
			
			$this->database->doQuery('UPDATE LOL_BUILDS SET icerik1 = ?, icerik2 = ?, icerik3 = ?, icerik1_bbcode = ?, icerik2_bbcode = ?, icerik3_bbcode = ?, isVisible = 1 WHERE id = ? AND writer = ?', $icerik1, $icerik2, $icerik3, $icerik1_bbcode, $icerik2_bbcode, $icerik3_bbcode, $_SESSION['buildID'], $_SESSION['Username']);
			
			//--Update Comet History
			$this->site->misc->addCometHistory($_SESSION['Username'] . ', yeni bir build oluşturdu.');
			$_SESSION['Step7Passed'] = TRUE;
			$this->doBuildErrorAjax('success');
		}
		
		function Step8()
		{
			$_SESSION['Step1Passed'] = FALSE; unset($_SESSION['Step1Passed']);
			$_SESSION['Step2Passed'] = FALSE; unset($_SESSION['Step2Passed']);
			$_SESSION['Step3Passed'] = FALSE; unset($_SESSION['Step3Passed']);
			$_SESSION['Step4Passed'] = FALSE; unset($_SESSION['Step4Passed']);
			$_SESSION['Step5Passed'] = FALSE; unset($_SESSION['Step5Passed']);
			$_SESSION['Step6Passed'] = FALSE; unset($_SESSION['Step6Passed']);
			$_SESSION['Step7Passed'] = FALSE; unset($_SESSION['Step7Passed']);
			$_SESSION['Step8Passed'] = FALSE; unset($_SESSION['Step8Passed']);
			
			$this->Success('İşte bu! Buildini başarıyla oluşturdun ve paylaştın.');
		}
		
		// ------------------------------------------- (Son) ------------------------------------------------
		
		function doProfileError($error)
		{
			Template::SetVar('ACCOUNT_PAGE_ERROR', '<@error@>');
			Template::SetVar('ERROR', $error);
			$this->content = Template::Load('account');
		}
		
		function doProfileSuccess($success)
		{
			Template::SetVar('ACCOUNT_PAGE_ERROR', '<@success@>');
			Template::SetVar('ERROR', $success);
			$this->content = Template::Load('account');
		}
		
		function doBuildErrorAjax($error)
		{
			Template::SetPage('page.ajax');
			$this->content = Template::Load('error', array('error' => $error));
		}

		function doBuildError($error, $pageNum)
		{
			Template::SetVar('infoarea', null);
			Template::SetVar('hata', '<@error@>');
			Template::SetVar('error', $error);
			$this->content = Template::Load('account_createbuild.part' . $pageNum);
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
			$this->content = Template::Load('account', array('ACCOUNT_PAGE_CONTENT' => NULL, 'ACCOUNT_PAGE_ERROR' => NULL));
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