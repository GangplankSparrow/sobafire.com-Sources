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
			Template::SetVar('title', $this->config['SITE']['TITLE'] . Template::GetLangVar('PAGE_BUILD_TITLE'));
		}

		function Run()
		{
			//-------------- GENEL ---------------
			$buildID = intval($_GET['buildID']);
			$sef = $this->site->misc->sefLink($_GET['sef']);
			
			$this->database->doQuery('SELECT * FROM LOL_BUILDS WHERE id= ?', $buildID);
			$row = $this->database->doRead();
			
			if($row['isVisible'] == 0)
			{
				$this->basicError('Bu build daha tamamlanmamış yada gösterimden kaldırılmış.');
				return;
			}
			
			$champID = $row['champNum'];
			Template::SetVar('BUILD_ID', $row['id']);
			Template::SetVar('CHAMP_WRITER', $row['writer']);
			Template::SetVar('BUILD_NAME', $row['buildName']);
			Template::SetVar('title', $this->config['SITE']['TITLE'] . $row['buildName']);
			
			
			$this->database->doQuery('select b.id,
  (select count(*) from lol_build_votes where build_id=b.id and vote = 1) as positive_votes,
  (select count(*) from lol_build_votes where build_id=b.id and vote = 0) as negative_votes FROM LOL_BUILDS b WHERE b.id = ?', $buildID);
			$voteRow = $this->database->doRead();
			
			if($voteRow['negative_votes'] == 0)
			{
				$negativeVotes = 0;
			}
			else
			{
				$negativeVotes = $voteRow['negative_votes'];
			}
			
			if($voteRow['positive_votes'] == 0)
			{
				$positiveVotes = 0;
			}
			else
			{	
				$positiveVotes = $voteRow['positive_votes'];
			}
			Template::SetVar('VOTE_POSITIVE', $positiveVotes);
			Template::SetVar('VOTE_NEGATIVE', $negativeVotes);
			Template::SetVar('WIDTH_PERCENT', $this->getPercent($positiveVotes, ($positiveVotes + $negativeVotes)));
			
			//-------------- RUNES ---------------
			$runeData = null;
			//----Mark
			$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeMark1']);
			$runeRow = $this->database->doRead();
			$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeMark1Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			
			if ($row['runeMark1Adet'] != 9)
			{
				$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeMark2']);
				$runeRow = $this->database->doRead();
				$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeMark2Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			}
			//----Seal
			$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeSeal1']);
			$runeRow = $this->database->doRead();
			$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeSeal1Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			
			if ($row['runeSeal1Adet'] != 9)
			{
				$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeSeal2']);
				$runeRow = $this->database->doRead();
				$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeSeal2Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			}
			//----Glyph
			$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeGlyph1']);
			$runeRow = $this->database->doRead();
			$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeGlyph1Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			
			if ($row['runeGlyph1Adet'] != 9)
			{
				$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeGlyph2']);
				$runeRow = $this->database->doRead();
				$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeGlyph2Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			}
			//----Quint
			$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeQuint1']);
			$runeRow = $this->database->doRead();
			$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeQuint1Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			
			if ($row['runeQuint1Adet'] != 3)
			{
				$this->database->doQuery('SELECT * FROM LOL_RUNES WHERE id = ?', $row['runeQuint2']);
				$runeRow = $this->database->doRead();
				$runeData .= '<tr><td><img src="<%THEME%>images/lol/runes/' . $runeRow['rune_image'] . '.png" alt="" title="runes_' . $runeRow['id'] . '" /></td><td class="text2">' . $row['runeQuint2Adet'] . '</td><td class="text">' . $runeRow['rune_name'] . '</td></tr>';
			}
			Template::SetVar('RUNE_DATA', $runeData);
			
			//-------------- SUMMONERS ---------------
			$summonerData = null;
			//----Mark
			$this->database->doQuery('SELECT * FROM LOL_SUMMONERS WHERE id = ?', $row['summoner1']);
			$summonerRow = $this->database->doRead();
			$summonerData .= '<img src="<%THEME%>images/lol/summoners/' . strtolower($summonerRow['summoner_image']) . '.png" alt="" title="summoners_' . $summonerRow['id'] . '" />';
			
			$this->database->doQuery('SELECT * FROM LOL_SUMMONERS WHERE id = ?', $row['summoner2']);
			$summonerRow = $this->database->doRead();
			$summonerData .= '<br><img src="<%THEME%>images/lol/summoners/' . strtolower($summonerRow['summoner_image']) . '.png" alt="" title="summoners_' . $summonerRow['id'] . '" />';
			Template::SetVar('SUMMONER_DATA', $summonerData);
			
			//-------------- KARAKTERLER (FİNAL) ---------------
			$this->database->doQuery('SELECT * FROM LOL_CHAMPIONS WHERE Num = ?', $champID);
			$champRow = $this->database->doRead();
			Template::SetVar('CHAMP_NAME', $champRow['champName']);
			Template::SetVar('CHAMP_LOWERCASE_NAME', $champRow['champLowercaseName']);
			Template::SetVar('BG_NUM', 'b' . rand(1,2));
			
			//-------------- SKILL SIRASI ---------------
			$arr_skills = str_split($row['skillOrder']);
			//--- (Pasif)
			$skillDataP = null;
			$this->database->doQuery('SELECT * FROM LOL_SKILLS WHERE SkillNum = ?', $champRow['Passive']);
			$skillRow = $this->database->doRead();
			if (strlen(trim($skillRow['TR'])) >= 1)
			{
				$skillDataP .= '<tr class="dark"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['TR_skillname'] . '</td>';
			}
			else
			{
				$skillDataP .= '<tr class="dark"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['EN_skillname'] . '</td>';
			}
			
			for($i = 0; $i <= 18; $i++) 
			{
				$skillDataP .= '<td></td>';
			}
			$skillDataP .= '</tr>';
			Template::SetVar('SKILLS_P', $skillDataP);
			
			//--- (Q) 
			$skillDataQ = null;
			$this->database->doQuery('SELECT * FROM LOL_SKILLS WHERE SkillNum = ?', $champRow['Q']);
			$skillRow = $this->database->doRead();
			if (strlen(trim($skillRow['TR'])) >= 1)
			{
				$skillDataQ .= '<tr class="light"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['TR_skillname'] . '</td>';
			}
			else
			{
				$skillDataQ .= '<tr class="light"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['EN_skillname'] . '</td>';
			}
			for($i = 0; $i <= 18; $i++) 
			{
				if($arr_skills[$i] == 1) { $skillDataQ .= '<td><img src="<%THEME%>images/skillingorder-dots.png" alt="X" /></td>'; }
				else { $skillDataQ .= '<td></td>'; }
			}
			$skillDataQ .= '</tr>';
			Template::SetVar('SKILLS_Q', $skillDataQ);
			
			//--- W
			$skillDataW = null;
			$this->database->doQuery('SELECT * FROM LOL_SKILLS WHERE SkillNum = ?', $champRow['W']);
			$skillRow = $this->database->doRead();
			if (strlen(trim($skillRow['TR'])) >= 1)
			{
				$skillDataW .= '<tr class="dark"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['TR_skillname'] . '</td>';	
			}
			else
			{
				$skillDataW .= '<tr class="dark"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['EN_skillname'] . '</td>';	
			}
			for($i = 0; $i <= 18; $i++) 
			{
				if($arr_skills[$i] == 2) { $skillDataW .= '<td><img src="<%THEME%>images/skillingorder-dots.png" alt="X" /></td>'; }
				else { $skillDataW .= '<td></td>'; }
			}
			$skillDataW .= '</tr>';
			Template::SetVar('SKILLS_W', $skillDataW);
			
			//--- E
			$skillDataE = null;
			$this->database->doQuery('SELECT * FROM LOL_SKILLS WHERE SkillNum = ?', $champRow['E']);
			$skillRow = $this->database->doRead();
			if (strlen(trim($skillRow['TR'])) >= 1)
			{
				$skillDataE .= '<tr class="light"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['TR_skillname'] . '</td>';
			}
			else
			{
				$skillDataE .= '<tr class="light"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['EN_skillname'] . '</td>';
			}
			for($i = 0; $i <= 18; $i++) 
			{
				if($arr_skills[$i] == 3) { $skillDataE .= '<td><img src="<%THEME%>images/skillingorder-dots.png" alt="X" /></td>'; }
				else { $skillDataE .= '<td></td>'; }
			}
			$skillDataE .= '</tr>';
			Template::SetVar('SKILLS_E', $skillDataE);
			
			//--- R
			$skillDataR = null;
			$this->database->doQuery('SELECT * FROM LOL_SKILLS WHERE SkillNum = ?', $champRow['R']);
			$skillRow = $this->database->doRead();
			if (strlen(trim($skillRow['TR'])) >= 1)
			{
				$skillDataR .= '<tr class="dark"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['TR_skillname'] . '</td>';
			}
			else
			{
				$skillDataR .= '<tr class="dark"><td><img src="<%THEME%>images/lol/abilities/' . $skillRow['imgPath'] . '" class="skillicon" alt="" title="skills_' . $skillRow['SkillNum'] . '" /></td><td class="skillname">' . $skillRow['EN_skillname'] . '</td>';
			}
			for($i = 0; $i <= 18; $i++) 
			{
				if($arr_skills[$i] == 4) { $skillDataR .= '<td><img src="<%THEME%>images/skillingorder-dots.png" alt="X" /></td>'; }
				else { $skillDataR .= '<td></td>'; }
			}
			$skillDataR .= '</tr>';
			Template::SetVar('SKILLS_R', $skillDataR);
			
			//-------------- ITEMLER ---------------
			//---early
			$arr_earlyitems = explode(',', $row['earlyItemsOrder']);
			$earlyItemsData = null;
			foreach($arr_earlyitems as $k => $v)
			{
				if($v != 0 || $v != false || !empty($v))
				{
					$this->database->doQuery('SELECT * FROM LOL_ITEMS WHERE item_id = ?', $v);
					$rowItem = $this->database->doRead();
					$earlyItemsData .= '<img src="<%THEME%>images/lol/items/' . $rowItem['item_id'] . '.png" class="vmiddle item full-spacing" alt="' . $rowItem['item_adi'] . '" title="items_' . $rowItem['item_id'] . '" /><img src="<%THEME%>images/horizontal-connect.png" class="vmiddle horizontal-spacing" alt="" />';
				}
			}
			Template::SetVar('ITEMS_LIST_EARLY', $earlyItemsData);
			
			//---mid
			$arr_miditems = explode(',', $row['midItemsOrder']);
			$midItemsData = null;
			foreach($arr_miditems as $k => $v)
			{
				if($v != 0 || $v != false || !empty($v))
				{
					$this->database->doQuery('SELECT * FROM LOL_ITEMS WHERE item_id = ?', $v);
					$rowItem = $this->database->doRead();
					$midItemsData .= '<img src="<%THEME%>images/lol/items/' . $rowItem['item_id'] . '.png" class="vmiddle item full-spacing" alt="' . $rowItem['item_adi'] . '" title="items_' . $rowItem['item_id'] . '" /><img src="<%THEME%>images/horizontal-connect.png" class="vmiddle horizontal-spacing" alt="" />';
				}
			}
			Template::SetVar('ITEMS_LIST_MID', $midItemsData);
			
			//---late
			$arr_lateitems = explode(',', $row['lateItemsOrder']);
			$lateItemsData = null;
			foreach($arr_lateitems as $k => $v)
			{
				if($v != 0 || $v != false || !empty($v))
				{
					$this->database->doQuery('SELECT * FROM LOL_ITEMS WHERE item_id = ?', $v);
					$rowItem = $this->database->doRead();
					$lateItemsData .= '<img src="<%THEME%>images/lol/items/' . $rowItem['item_id'] . '.png" class="vmiddle item full-spacing" alt="' . $rowItem['item_adi'] . '" title="items_' . $rowItem['item_id'] . '" /><img src="<%THEME%>images/horizontal-connect.png" class="vmiddle horizontal-spacing" alt="" />';
				}
			}
			Template::SetVar('ITEMS_LIST_LATE', $lateItemsData);
			
			//-------------- MASTERYLER ---------------
			Template::SetVar('OF_COUNT', $this->getOffenseCount($row['masteryNum']));
			Template::SetVar('DEF_COUNT', $this->getDefenseCount($row['masteryNum']));
			Template::SetVar('UT_COUNT', $this->getUtilityCount($row['masteryNum']));
			
			$arr_masteries = explode(',', $row['masteryNum']);
			for($i = 0; $i <= 50; $i++)
			{
				if($arr_masteries[$i] >= 1)
				{
					Template::SetVar('M' . ($i+1), $arr_masteries[$i]);
					Template::SetVar('IS_ZERO_' . ($i+1), '');
				}
				else
				{
					Template::SetVar('M' . ($i+1), '0');
					Template::SetVar('IS_ZERO_' . ($i+1), '0');
				}
			}
			
			//-------------- EDİTLEME --------------
			if(isset($_SESSION['Yetki']) && $_SESSION['Yetki'] == 0)
			{
				Template::SetVar('BUILD_EDITABLE', 'Admin yetkisine sahipsiniz. <br>Hangi bölümü düzenlemek istiyorsunuz?<br><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=1">Build adını düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=2">Summoner spellerinizi düzenleyin</a><br> 
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=3">Skill puanlarınızı düzenleyin</a><br> 
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=4">Runelerinizi düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=5">Masterylerinizi düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=6">İtemlerinizi düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=7">İçerik yazılarınızı düzenleyin</a><br><br><b>Önemli:</b> Yaptığınız güncellemeler 10 dakika içerisinde aktif olacaktır. Güncelleme yaptıktan sonra önbellek dosyasının güncellenmesi için biraz bekleyin.');
			}
			else if($_SESSION['Username'] == $row['writer'])
			{
				Template::SetVar('BUILD_EDITABLE', 'Bu buildin sahibi sizsiniz. Düzenleme yapmak istiyorsanız aşağıdan bir bölüm seçin.<br>Hangi bölümü düzenlemek istiyorsunuz?<br><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=1">Build adını düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=2">Summoner spellerinizi düzenleyin</a><br> 
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=3">Skill puanlarınızı düzenleyin</a><br> 
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=4">Runelerinizi düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=5">Masterylerinizi düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=6">İtemlerinizi düzenleyin</a><br>
													<a href="' . $this->config['SITE']['HOST'] . '?page=account&s=editbuild&buildID=' . $buildID . '&act=7">İçerik yazılarınızı düzenleyin</a><br><br><b>Önemli:</b> Yaptığınız güncellemeler 10 dakika içerisinde aktif olacaktır. Güncelleme yaptıktan sonra önbellek dosyasının güncellenmesi için biraz bekleyin.');
			}
			else
			{
				Template::SetVar('BUILD_EDITABLE', 'Bu build size ait olmadığı için düzenleme yapamazsınız.');
			}
			
			//-------------- YAZILAR ---------------
			
			Template::SetVar('ICERIK_1', $row['icerik1']);
			Template::SetVar('ICERIK_2', $row['icerik2']);
			Template::SetVar('ICERIK_3', $row['icerik3']);
			
			//-------------- YORUMLAR ---------------
			
			Template::SetVar('BUILD_YORUMLAR', $this->showComments($buildID));
			Template::SetVar('BUILD_YORUMEKLE', $this->showCommentingForm());
			Template::SetVar('BUILD_VOTEEKLE', $this->showVotingIcons($buildID));
			
			//--Update Comet History
			if (isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == TRUE) 
			{
				$this->site->misc->addCometHistory($_SESSION['Username'] . ', ' . $row['buildName'] . ' buildini inceliyor.');
			}
			else
			{
				$this->site->misc->addCometHistory($this->site->GetRemoteIP() . ', ' . $row['buildName'] . ' buildini inceliyor.');
			}
			
			$this->content = Template::Load('build');
		}
		
		function showCommentingForm()
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{
				return 'Buidlere yorum yapabilmek için önce giriş yapmış olmanız gerekiyor.';
			}
			else
			{
				return Template::Load('build.addcomment');
			}
		}
		
		function showVotingIcons($buildID)
		{
			if (!isset($_SESSION['bLoggedIn']) || $_SESSION['bLoggedIn'] == FALSE)
			{
				Template::SetVar('ICON_POSITIVE', NULL);
				Template::SetVar('ICON_NEGATIVE', NULL);
			}
			else
			{
				Template::SetVar('ICON_POSITIVE', '<a href="' . $this->site->config['SITE']['HOST'] . '?page=account&s=votebuild&buildID=' . $buildID . '&vote=1"><img src="<%THEME%>images/vote-up.gif"></a>');
				Template::SetVar('ICON_NEGATIVE', '<a href="' . $this->site->config['SITE']['HOST'] . '?page=account&s=votebuild&buildID=' . $buildID . '&vote=0"><img src="<%THEME%>images/vote-down.gif"></a>');
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
				return 'Bu builde hiç yorum yapılmamış.';
			}
			else
			{
				return $this->site->bbcode->readBBCode($comments);
			}
		}
		
		function getOffenseCount($masteryNum)
		{
			$masteryNumClear = str_replace(',', '', $masteryNum);
			$data = substr($masteryNumClear, 0, 17);
			$array_data = str_split($data);
			foreach($array_data as $k => $v)
			{
				$total += $v;
			}
			if($total >= 0)
				return $total;
			return '0';
		}
		
		function getDefenseCount($masteryNum)
		{
			$masteryNumClear = str_replace(',', '', $masteryNum);
			$data = substr($masteryNumClear, 17, 16);
			$array_data = str_split($data);
			$total = null;
			foreach($array_data as $k => $v)
			{
				$total += $v;
			}

			if($total >= 0)
				return $total;
			return '0';
		}
		
		function getUtilityCount($masteryNum)
		{
			$masteryNumClear = str_replace(',', '', $masteryNum);
			$data = substr($masteryNumClear, 33, 16);
			$array_data = str_split($data);
			$total = null;
			foreach($array_data as $k => $v)
			{
				$total += $v;
			}
			
			if($total >= 0)
				return $total;
			return '0';
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
		
		function Error($error)
		{
			$this->content = Template::Load('error', array('ERROR' => Template::GetLangVar($error)));
		}
		
		function basicError($error)
		{
			$this->content = Template::Load('error', array('ERROR' => $error));
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