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
	<%INFOAREA%>
	<%HATA%>
	<form id="form" action="?page=account&s=editbuild&buildID=<%BUILD_ID%>&act=5" method="POST">
	
	Masterylerinizi düzenleyin,<br>
	Toplam 30 adet seçim yapabilirsiniz. Kalan mastery puanınız en altta görünür.
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
		
	<br><br>
	<input type="submit" name="submit" id="submit" value="Düzenle"></input>
	</form>
</div>