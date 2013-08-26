<link rel="stylesheet" href="<%THEME%>css/builds.css" type="text/css" media="screen" title="no title" charset="utf-8" />
<script src="<%THEME%>js/jquery-1.4.4.min.js" type="text/javascript"></script>
<style type="text/css">
	.silverBigBox .silverBigBoxMid{padding:0px 1px}
	.small_masteries2 td .box img.disabled {position: relative;top: -56px;z-index: 5;}
</style>

<script type="text/javascript">
	  $(document).ready(function() 
	  {
		$('img').bind("contextmenu", function(e){ return false; })
	  });
</script>


	<div align="center">
		<%HATA%>
	<form id="form" action="?page=account&s=createbuild" method="POST">
		
		Build adını girin,<br>
		-60 karakterden uzun yazı girerseniz hata alabilirsiniz.<br><br>
		<input type="text" name="build_adi" id="build_adi" size="60"></input>
		<hr>
		
		Karakterinizi seçin,<br><br> 
		<select name="champions">
			<%SELECT_CHARACTERS%>
		</select>
		<hr>
		
		Summoner spellerinizi seçin,<br> <br> 
		1. summoner: <select name="summoner1">
			<%SELECT_SUMMONERS%>
		</select><br>
		
		2. summoner: <select name="summoner2">
			<%SELECT_SUMMONERS%>
		</select><br>
		
		<hr>
		
		Skill sıranızı oluşturun,<br> 
		-Skill sıranızın doğru olduğuna emin olun, aksi takdirde buildiniz silinebilir.<br><br>
		<%SELECT_SKILLS%>
		
		<hr>
		
		Runelerinizi oluşturun,<br>
		-Toplam rune sayısı Quint'ler için 3, diğer runeler için maksimum 9'dur.<br>
		-Bu sayıyı geçerseniz hata alırsınız ve seçimleriniz boşa gider.<br> 
		-Eğer ek bir rune kullanmak istemiyorsanız, lütfen 2. rune bölümünün adet kısmını boş bırakın.<br><br>
		
		Quint (1) <select name="runes_quint1">
				  <option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_QUINT%>
				   </select>
				   Adet: <input type="text" name="runes_quint1_adet" id="runes_quint1_adet" size="4"></input><br>
				   
		Quint (2) <select name="runes_quint2">
					<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_QUINT%>
				   </select>
				   Adet: <input type="text" name="runes_quint2_adet" id="runes_quint2_adet" size="4"></input><br>
		<br>
		
		Seal (1) <select name="runes_seal1">
				<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_SEAL%>
				   </select>
				   Adet: <input type="text" name="runes_seal1_adet" id="runes_seal1_adet" size="4"></input><br>
				   
		Seal (2) <select name="runes_seal2">
		<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_SEAL%>
				   </select>
				   Adet: <input type="text" name="runes_seal2_adet" id="runes_seal2_adet" size="4"></input><br>
		<br>
		
		Mark (1) <select name="runes_mark1">
		<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_MARK%>
				   </select>
				   Adet: <input type="text" name="runes_mark1_adet" id="runes_mark1_adet" size="4"></input><br>
				   
		Mark (2) <select name="runes_mark2">
		<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_MARK%>
				   </select>
				   Adet: <input type="text" name="runes_mark2_adet" id="runes_mark2_adet" size="4"></input><br>
		<br>
		
		Glyph (1) <select name="runes_glyph1">
		<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_GLYPH%>
				   </select>
				   Adet: <input type="text" name="runes_glyph1_adet" id="runes_glyph1_adet" size="4"></input><br>
				   
		Glyph (2) <select name="runes_glyph2">
		<option value="0">Seçiniz...</option>
				  <%SELECT_RUNES_GLYPH%>
				   </select>
				   Adet: <input type="text" name="runes_glyph2_adet" id="runes_glyph2_adet" size="4"></input><br>
		<br>
		
		<hr>
		Masterylerinizi oluşturun,
	<div id="top" class="guideSilver" style="padding-left: 5px;padding-right:5px;">
	<div class="shaderf">
	<div class="silverBody">
				<div class="small_masteries2">
					<table>
		<tr>
			<td style="background: #2E0708 url('<%THEME%>images/lol/masteries/masteries-offense.jpg') top center no-repeat">
				<div class="treetitle">
					<img class="vmiddle" width="30" height="30" alt="" src="<%THEME%>images/lol/masteries/offense.png">
					<span id="offense" data-id="Offense" class="vmiddle">Offense</span>
				</div>
				<div class="masttree">
					<div class="clear">
						<div class="box" id="offense_1">
							<img alt="Summoner's Wrath" title="Summoner's Wrath" src="<%THEME%>images/lol/masteries/summoners_wrath.png"><br>
							<img class="disabled" alt="" src="<%THEME%>images/lol/masteries/0.png"><br>
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="offense_2">
							<img alt="" src="<%THEME%>images/lol/masteries/brute_force.png" title="Brute Force"><br>
							<img class="disabled" alt="" src="<%THEME%>images/lol/masteries/0.png"><br>
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="offense_3">
							<img alt="" src="<%THEME%>images/lol/masteries/mental_force.png" title="Mental Force"><br>
							<img class="disabled" alt="" src="<%THEME%>images/lol/masteries/0.png"><br>
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="offense_4">
							<img src="<%THEME%>images/lol/masteries/butcher.png" alt="" title="Butcher" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="2">0/2</span>
						</div>
					</div>
												
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="offense_5">
							<img src="<%THEME%>images/lol/masteries/alacrity.png" alt="" title="Alacrity" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="offense_6">
							<img src="<%THEME%>images/lol/masteries/sorcery.png" alt="" title="Sorcery" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="offense_7">
							<img src="<%THEME%>images/lol/masteries/demolitionist.png" alt="" title="Demolitionist" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /> <br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
					<div class="clear">
						<div class="box" id="offense_8">
							<img src="<%THEME%>images/lol/masteries/deadliness.png" alt="" title="Deadliness" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="offense_9">
							<img src="<%THEME%>images/lol/masteries/weapon_expertise.png" alt="" title="Weapon Expertise" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="offense_10">
							<img src="<%THEME%>images/lol/masteries/arcane_knowledge.png" alt="" title="Arcane Knowledge" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="offense_11">
							<img src="<%THEME%>images/lol/masteries/havoc.png" alt="" title="Havoc" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
					</div>
					<div class="clear">
						<div class="box" id="offense_12">
							<img src="<%THEME%>images/lol/masteries/lethality.png" alt="" title="Lethality" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="offense_13">
							<img src="<%THEME%>images/lol/masteries/vampirism.png" alt="" title="Vampirism" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="offense_14">
							<img src="<%THEME%>images/lol/masteries/blast.png" alt="" title="Blast" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
					</div>
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="offense_15">
							<img src="<%THEME%>images/lol/masteries/sunder.png" alt="" title="Sunder" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="offense_16">
							<img src="<%THEME%>images/lol/masteries/archmage.png" alt="" title="Archmage" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
					</div>
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="offense_17">
							<img src="<%THEME%>images/lol/masteries/executioner.png" alt="" title="Executioner" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
				</div>
				
			</td>
			<td style="background: #04090F url('<%THEME%>images/lol/masteries/masteries-defense.jpg') top center no-repeat">
				<div class="treetitle">
					<img class="vmiddle" width="30" height="30" alt="" src="<%THEME%>images/lol/masteries/defense.png">
					<span id="defense" data-id="Defense" class="vmiddle">Defense</span>
				</div>
				<div class="masttree">
					<div class="clear">
						<div class="box" id="defense_1">
							<img src="<%THEME%>images/lol/masteries/summoners_resolve.png" alt="" title="Summoner's Resolve" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="defense_2">
							<img src="<%THEME%>images/lol/masteries/resistance.png" alt="" title="Resistance" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="defense_3">
							<img src="<%THEME%>images/lol/masteries/hardiness.png" alt="" title="Hardiness" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>

						<div class="box" id="defense_4">
							<img src="<%THEME%>images/lol/masteries/tough_skin.png" alt="" title="Tough Skin" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="2">0/2</span>
						</div>
					</div>

					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="defense_5">
							<img src="<%THEME%>images/lol/masteries/durability.png" alt="" title="Durability" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="defense_6">
							<img src="<%THEME%>images/lol/masteries/vigor.png" alt="" title="Vigor" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
					</div>

					<div class="clear">
						<div class="box" id="defense_7">
							<img src="<%THEME%>images/lol/masteries/indomitable.png" alt="" title="Indomitable" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="2">0/2</span>
						</div>
						<div class="box" id="defense_8">
							<img src="<%THEME%>images/lol/masteries/veterans_scars.png" alt="" title="Veteran's Scars" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="defense_9">
							<img src="<%THEME%>images/lol/masteries/evasion.png" alt="" title="Evasion" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="defense_10">
							<img src="<%THEME%>images/lol/masteries/bladed_armor.png" alt="" title="Bladed Armor" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
					<div class="clear">

						<div class="box" id="defense_11">
							<img src="<%THEME%>images/lol/masteries/siege_commander.png" alt="" title="Siege Commander" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="defense_12">
							<img src="<%THEME%>images/lol/masteries/initiator.png" alt="" title="Initiator" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="defense_13">
							<img src="<%THEME%>images/lol/masteries/enlightenment.png" alt="" title="Enlightenment" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
					</div>
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="defense_14">
							<img src="<%THEME%>images/lol/masteries/honor_guard.png" alt="" title="Honor Guard" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="defense_15">
							<img src="<%THEME%>images/lol/masteries/mercenary.png" alt="" title="Mercenary" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="defense_16">
							<img src="<%THEME%>images/lol/masteries/juggernaut.png" alt="" title="Juggernaut" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
				</div>
			</td>
			<td style="background: #010300 url('<%THEME%>images/lol/masteries/masteries-utility.jpg') top center no-repeat">
				<div class="treetitle">
					<img class="vmiddle" width="30" height="30" alt="" src="<%THEME%>images/lol/masteries/utility.png">
					<span id="utility" data-id="Utility" class="vmiddle">Utility</span>
				</div>
				<div class="masttree">
					<div class="clear">
						<div class="box" id="utility_1">
							<img src="<%THEME%>images/lol/masteries/summoners_insight.png" alt="" title="Summoner's Insight" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
						<div class="box" id="utility_2">
							<img src="<%THEME%>images/lol/masteries/good_hands.png" alt="" title="Good Hands" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="utility_3">
							<img src="<%THEME%>images/lol/masteries/expanded_mind.png" alt="" title="Expanded Mind" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="utility_4">
							<img src="<%THEME%>images/lol/masteries/improved_recall.png" alt="" title="Improved Recall" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
						
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="utility_5">
							<img src="<%THEME%>images/lol/masteries/swiftness.png" alt="" title="Swiftness" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="utility_6">
							<img src="<%THEME%>images/lol/masteries/meditation.png" alt="" title="Meditation" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>

						</div>
						<div class="box" id="utility_6">
							<img src="<%THEME%>images/lol/masteries/scout.png" alt="" title="Scout" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>

						</div>
					</div>
						
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="utility_7">
							<img src="<%THEME%>images/lol/masteries/greed.png" alt="" title="Greed" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>
						</div>
						<div class="box" id="utility_8">
							<img src="<%THEME%>images/lol/masteries/transmutation.png" alt="" title="Transmutation" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>

						</div>
						<div class="box" id="utility_9">
							<img src="<%THEME%>images/lol/masteries/runic_affinity.png" alt="" title="Runic Affinity" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>

						</div>
					</div>
						
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="utility_10">
							<img src="<%THEME%>images/lol/masteries/wealth.png" alt="" title="Wealth" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="2">0/2</span>
						</div>
						<div class="box" id="utility_11">
							<img src="<%THEME%>images/lol/masteries/awareness.png" alt="" title="Awareness" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="4">0/4</span>

						</div>
						<div class="box" id="utility_12">
							<img src="<%THEME%>images/lol/masteries/sage.png" alt="" title="Sage" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="1">0/1</span>

						</div>
					</div>
						
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="utility_13">
							<img src="<%THEME%>images/lol/masteries/perseverance.png" alt="" title="Perseverance" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
						<div class="box" id="utility_14">
							<img src="<%THEME%>images/lol/masteries/intelligence.png" alt="" title="Intelligence" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />
							<span class="boxtext" data-max="3">0/3</span>
						</div>
					</div>
						
					<div class="clear">
						<div class="sb"></div>
						<div class="box" id="utility_15">
							<img src="<%THEME%>images/lol/masteries/mastermind.png" alt="" title="Mastermind" /><br />
							<img src="<%THEME%>images/lol/masteries/0.png" class="disabled" alt="" /><br />

							<span class="boxtext" data-max="1">0/1</span>
						</div>
					</div>
					
				</div>
			</td>
		</tr>
	</table>
	</div>
	<span class="sonuc">Kalan puan sayısı: 30<br></span>
	<input type="hidden" name="mastery_num" id="mastery_num" value="" ></input>
	
	<script type="text/javascript">
var remaining = 30;
$('.box').mousedown( function(el) 
{
	if (el.which === 1) // sol tık
	{
		if (remaining == 0)
			return;
		var resBox = $(this).find('.boxtext');
		var curVal = resBox.attr('_data-value');
		var MAX_VALUE = resBox.attr("data-max");
	
		if (!curVal)
			curVal = 0;
		if (curVal >= MAX_VALUE)
			return;
		curVal++;
		remaining--;
		resBox.text(curVal + '/' + MAX_VALUE);
		resBox.attr('_data-value', curVal);
		
		var numString = $('.boxtext').map(function() 
		{ 
			var s = $(this).attr('_data-value'); 
			
			if (s == undefined) 
				s = '0'; 
			
			return s; 
		}).get().join();
		
		$("#mastery_num").val(numString);
		$(".sonuc").html('Kalan puan sayısı: ' + remaining + '<br>');
	}
	
	if (el.which === 3) // sağ tık
	{
		if (remaining <= 0)
			return;
			
		var resBox = $(this).find('.boxtext');
		var curVal = resBox.attr('_data-value');
		var MAX_VALUE = resBox.attr("data-max");
	
		if (!curVal)
			curVal = 0;
		if (curVal <= 0)
			return;
		curVal--;
		remaining++;
		resBox.text(curVal + '/' + MAX_VALUE);
		resBox.attr('_data-value', curVal);
		
		var numString = $('.boxtext').map(function() 
		{ 
			var s = $(this).attr('_data-value'); 
			
			if (s == undefined) 
				s = '0'; 
			
			return s; 
		}).get().join();
		
		$("#mastery_num").val(numString);
		$(".sonuc").html('Kalan puan sayısı: ' + remaining + '<br>');
	}
});
</script>
</div></div></div>
		
		<br>   
		
		<hr>
		İtemlerinizi seçin,<br><br> 
		<h3>Oyun Başı</h3>
		-Oyunun başında maksimum 450 altın (support iseniz 490 altın) ile başlayabilirsiniz.<br>
		-Bu fiyattan yüksek itemleri seçtiğiniz takdirde sistem bunu kabul etmeyecektir.<br>
		1. item: <select name="item_early1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		2. item: <select name="item_early2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		3. item: <select name="item_early3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		4. item: <select name="item_early4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		5. item: <select name="item_early5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		6. item: <select name="item_early6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br><br>
		
		<h3>Oyun Ortası</h3>
		-Oyunun ortasında ortalama 2500-3500g kadar para kazanmış olursunuz.<br>
		-Bu bölümde istediğiniz itemleri kullanabilirsiniz, ancak 3500g'yi geçmemeye çalışın.<br>
		1. item: <select name="item_mid1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		2. item: <select name="item_mid2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		3. item: <select name="item_mid3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		4. item: <select name="item_mid4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		5. item: <select name="item_mid5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		6. item: <select name="item_mid6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br><br>
		
		<h3>Oyun Sonu</h3>
		-Burada oyunun sonunda tamamlayacağız tam buildi seçin.<br>
		-İstediğiniz itemleri seçebilirsiniz, bu sizin son buildinizdir ve tüm itemler dahildir.<br>
		1. item: <select name="item_late1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		2. item: <select name="item_late2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		3. item: <select name="item_late3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		4. item: <select name="item_late4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		5. item: <select name="item_late5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		6. item: <select name="item_late6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		<hr>
		Giriş-Gelişme-Sonuç yazılarınızı yazın;<br><br> 
		<h3>Giriş Bölümü</h3>
		-Bu bölümde genellikle seçilen karakterin artıları ve eksilerinden bahsedilir, kısaca bilgi verilir.<br>
		-Jungle yapılıyorsa hangi yolun izleneceği vb. tarzda yazılar yazılır.<br>
		<textarea type="text" rows="10" cols="60" name="icerik1" id="icerik1"></textarea><br><br>
		
		<h3>Gelişme Bölümü</h3>
		-Bu bölümde genellikle oyun ortasındaki rolünüz hakkında bilgi verilir.<br>
		-Karakterin ana itemleri yazılır ve bu itemlerin neden alındığı hakkında bilgi verilir.<br>
		<textarea type="text" rows="10" cols="60" name="icerik2" id="icerik2"></textarea><br><br>
		
		<h3>Sonuç Bölümü</h3>
		-Bu bölümde bahsetmek istediğiniz herşeyi yazabilirsiniz. Tamamen size kalmış!<br>
		<textarea type="text" rows="10" cols="60" name="icerik3" id="icerik3"></textarea><br><br>
		
		
		Herşey tamam mı? <br>
		<blink>-Lütfen kontrol edin çünkü hata alırsanız yaptığınız seçimler & yazdığınız yazılar resetlenecektir!!</blink><br>
		Herşey tamamsa, butona tıklayarak buildinizi ekleyin.<br><br>
		<input type="submit" name="submit" id="submit" value="Buildimi Ekle"></input>
	</form>
</div>
<div id="pop"></div>
	<div id="dpoph"></div>
	<div id="dpophloading">Yükleniyor...<br /><img src="<%THEME%>images/loading.gif" alt="" /></div>
	<div id="poperr">Yükleme tamamlanamadı. Sunucular yoğun olabilir.</div>
	<div id="bottomlimit"></div>
	
<script type="text/javascript">
	<!--
		$(".disabled").each(function() {
			$(this).attr("title",$(this).siblings("img").attr("title"));
		});
		
		$.ajaxSetup ({ cache: false }); 
		function getData(t,c0,c1) {
			$("#"+t).load("http://www.sobafire.com/ajax.php", {'c0': c0, 'c1': c1,}, 
			function(response, status, xhr) {
				if (status=="error") {
					$("#"+t).html($("#poperr").html());
				}
				
				$("#pop").html($("#"+t).html());
				kgo();
			});
		}

		$(".guideSilver img").each(function(){
			$(this).data("title",$(this).attr("title")).removeAttr("title");
			
			if ($(this).data("title")!="") 
			{
				var c=$(this).data("title");
				var cs=c.split("http://www.sobafire.com/");
				var c0=cs[0].replace(/[\W]/g,"");
				$(this).data("cx0",cs[0]);

				if (c0=="items") {
					var c1=c.substr(cs[0].length+1).replace(/[\W\d]/g,"");
					$(this).data("cx1",c.substr(cs[0].length+1).replace(/["'\s\d]/g,""));
				}
				else {
					var c1=c.substr(cs[0].length+1).replace(/[\W]/g,"");
					$(this).data("cx1",c.substr(cs[0].length+1).replace(/["'\s]/g,""));
				}
				
				$(this).data("c0",c0);
				$(this).data("c1",c1);
			}
		});
		$(".guideSilver img").load(function(){
			if ($(this).attr("width")+"px"==$(this).css("max-width")) {
				$(this).wrap('<a href="'+$(this).attr("src")+'" title="View full image"></a>');
			}
		});
		
		var mymousex;
		var mymousey;
		
		function kgo() {
			var offset = $(".guideSilver").offset();
			var maxx=offset.left+$(".guideSilver").outerWidth();
			var maxy=$("#bottomlimit").offset().top-10;

			myy=mymousey+15;
			myx=mymousex-($("#pop").width()/2)-20;
			
			if (myx<offset.left+1)
				myx=offset.left+1;
			if (myx>maxx-($("#pop").outerWidth())-1)
				myx=maxx-($("#pop").outerWidth())-1;
			if (myy>maxy-($("#pop").outerHeight())) {
				myy=mymousey-$("#pop").outerHeight()-15;
			}					
			
			$("#pop").css({
				left: myx + "px",
				top: myy + "px"
			});
		}
		
		
		$(".guideSilver img").mousemove(function(e){
			mymousex=e.pageX;
			mymousey=e.pageY;

			var c0=$(this).data("c0");
			var c1=$(this).data("c1");
			
			if (!c0) return;
			
			if (c0!="custom" && c1) {
				var c2="dpoph_"+c0+"_"+c1;
				if (!$("#"+c2).length) {
					$('<div id="'+c2+'" style="display: none">'+c2+'</div>').appendTo($("#dpoph"));
					$("#"+c2).html($("#dpophloading").html());
					
					getData(c2,$(this).data("cx0"),$(this).data("cx1"));
				}

				$("#pop").html($("#"+c2).html());
				$("#pop").show();
				kgo();
			}
			else if (c0!="custom") {
				var c2="dpoph_"+c0;
				if (!$("#"+c2).length) {
					$('<div id="'+c2+'" style="display: none">'+c2+'</div>').appendTo($("#dpoph"));
					$("#"+c2).html($("#dpophloading").html());
					
					getData(c2,"masteries",$(this).data("cx0"));
				}

				$("#pop").html($("#"+c2).html());
				$("#pop").show();
				kgo();
			}
		});
		
		$(".guideSilver img").mouseout(function(e){
			$("#pop").hide();
		});
	//-->
	</script>