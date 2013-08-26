<script src="<%THEME%>js/jquery-1.4.4.min.js" type="text/javascript"></script>

<!-- BAŞ -->
<div id="top" class="guideSilver" style="background: #111113 url('<%THEME%>images/lol/backgrounds/<%CHAMP_LOWERCASE_NAME%>/<%BG_NUM%>.jpg') top right no-repeat;padding-left: 5px;padding-right:5px;">
	<img class="shader" src="<%THEME%>images/b-shadow.png" alt="" />
	<div class="shaderf">
		<div class="title">
			<span class="champname"><%CHAMP_NAME%></span>
			<div class="guideSilverName"><%BUILD_NAME%></div>		
			<div class="guideSilverAuthor"><%CHAMP_WRITER%> yazdı.</div>
		</div>
	
		<div class="votes">
			Bu buildin oylama durumu<br />
			<%ICON_POSITIVE%> <%ICON_NEGATIVE%><br />				
			<div class="dislikeBar">
				<div class="likeBar" style="width:<%WIDTH_PERCENT%>%"></div>
			</div>
			<span class="like"><%VOTE_POSITIVE%></span> pozitif
			<div class="textSpacer"></div>
			<span class="dislike"><%VOTE_NEGATIVE%></span> negatif
		</div>
		
		<table class="floatLeft">
			<tr>
				<td>
					<div class="silverTitle">
						<div class="silverTitleLeft">
							<img src="<%THEME%>images/rune.png" alt="RUNES" /><img src="<%THEME%>images/right_arrow.png" alt="&gt;" class="rightArrow" />
						</div>
						<div class="silverTitleRight"></div>
					</div>
					<div class="silverBody"> 
						<!-- Rune Başlangıç -->
						<div class="runes">
							<table>
								<%RUNE_DATA%>
							</table>
						</div>
						<!-- Rune Son -->
					</div>
	
				</td>
				<td valign="bottom">
					<div class="summoners"><!-- İKİLİ SUMMONER BÖLÜMÜ BAŞ -->
						<%SUMMONER_DATA%>
					</div><!-- İKİLİ SUMMONER BÖLÜMÜ SON -->
				</td>
			</tr>
		</table>
		
		<div class="clear"></div>
	
	<@BUILD.SEASON2.MASTERIES@>
	
	<div class="silverTitle">
		<div class="silverTitleLeft">
			<img src="<%THEME%>images/skill.png" alt="SKILL ORDER" /><img src="<%THEME%>images/right_arrow.png" alt="&gt;" class="rightArrow" />
		</div>
		<div class="silverTitleRight"></div>
	</div>
	<div class="silverBody">
		<div class="skilling">
			<table>
				<tr>
					<th class="image"></th>
					<th class="level skillname">Seviye</th>
					<th class="number">1</th>
					<th class="number">2</th>
					<th class="number">3</th>
					<th class="number">4</th>
					<th class="number">5</th>
					<th class="number">6</th>
					<th class="number">7</th>
					<th class="number">8</th>
					<th class="number">9</th>
					<th class="number">10</th>
					<th class="number">11</th>
					<th class="number">12</th>
					<th class="number">13</th>
					<th class="number">14</th>
					<th class="number">15</th>
					<th class="number">16</th>
					<th class="number">17</th>
					<th class="number">18</th>
				</tr>
						<%SKILLS_P%>
						<%SKILLS_Q%>
						<%SKILLS_W%>
						<%SKILLS_E%>
						<%SKILLS_R%>
				</table>
		</div>
	</div>

	<!-- itemler 1 -->
	<div class="silverTitle">
		<div class="silverTitleLeft">
			<img src="<%THEME%>images/item.png" alt="ITEM BUILD" /><img src="<%THEME%>images/right_arrow.png" alt="&gt;" class="rightArrow" />
		</div>
		<div class="silverTitleRight"></div>
	</div>
	<div class="silverBody">
		<div class="items">
			<div class="itemsbox">
				<div class="itemsboxcontent">
					Oyunun başında alınacak itemler<br>
					<%ITEMS_LIST_EARLY%>
				</div>
			</div>
		</div>
	</div>
	
	<!-- itemler 2 -->
	<div class="silverTitle">
		<div class="silverTitleLeft">
			<img src="<%THEME%>images/item.png" alt="ITEM BUILD" /><img src="<%THEME%>images/right_arrow.png" alt="&gt;" class="rightArrow" />
		</div>
		<div class="silverTitleRight"></div>
	</div>
	<div class="silverBody">
		<div class="items">
			<div class="itemsbox">
				<div class="itemsboxcontent">
					Oyunun ortasında alınacak itemler<br>
					<%ITEMS_LIST_MID%>
				</div>
			</div>
		</div>
	</div>
	
	<!-- itemler 3 -->
	<div class="silverTitle">
		<div class="silverTitleLeft">
			<img src="<%THEME%>images/item.png" alt="ITEM BUILD" /><img src="<%THEME%>images/right_arrow.png" alt="&gt;" class="rightArrow" />
		</div>
		<div class="silverTitleRight"></div>
	</div>
	<div class="silverBody">
		<div class="items">
			<div class="itemsbox">
				<div class="itemsboxcontent">
					Oyunun sonunda alınacak itemler<br>
					<%ITEMS_LIST_LATE%>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="content">
			<div class="chapter" id="chap1">
				<div class="textbox">
					<div class="chaptitle">
						Giriş
						
						<div class="clear"></div>
					</div>
					<%ICERIK_1%><br />
				</div>
			</div>

						
			<div class="chapter" id="chap2">
				<div class="textbox">
					<div class="chaptitle">
						Gelişme
						
						<div class="clear"></div>
					</div>
					<%ICERIK_2%><br />
				</div>
			</div>
			
			<div class="chapter" id="chap3">
				<div class="textbox">
					<div class="chaptitle">
						Sonuç
						
						<div class="clear"></div>
					</div>
					<%ICERIK_3%><br />
				</div>
			</div>
			
			<!-- BUİLD EDİTLEME -->
			<div class="chapter" id="chap3">
				<div class="textbox">
					<div class="chaptitle">
						Build Düzenleme
						
						<div class="clear"></div>
					</div>
					<%BUILD_EDITABLE%><br />
				</div>
			</div>
			
			<!-- YORUMLAR -->
			<div class="chapter" id="chap3">
				<div class="textbox">
					<div class="chaptitle">
						Yorumlar
						
						<div class="clear"></div>
					</div>
					
					<div class="browseBuilds">
						<%BUILD_YORUMLAR%>
					</div>
					
					<%BUILD_YORUMEKLE%>
				</div>
			</div>
			
		</div>
	</div>
</div>
 <!-- SON -->
 
	<div id="pop"></div>
	<div id="dpoph"></div>
	<div id="dpophloading">Yükleniyor...<br /><img src="<%THEME%>images/loading.gif" alt="" /></div>
	<div id="poperr">Yükleme tamamlanamadı. Sunucular yoğun olabilir.</div>
	<div id="bottomlimit"></div>

	
	<!-- Build Scripts & Ajax -->
	<script type="text/javascript">
		var mymousex;
		var mymousey;
		
		function getData(type,c0,c1) {
			$("#"+type).load("http://www.sobafire.com/?page=ajax", {'c0': c0, 'c1': c1,}, function(response) {		
				$("#pop").html($("#"+type).html());
				kgo();
			});
		}

		$(".guideSilver img").each(function(){
			$(this).data("title", $(this).attr("title")).removeAttr("title");
			
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
				left: (myx - 300) + "px",
				top: (myy + 5) + "px"
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
					$('<div id="'+c2+'" style="display: none">'+c2+'</div>').appendTo($("#dpoph")); //cachele
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
					$('<div id="'+c2+'" style="display: none">'+c2+'</div>').appendTo($("#dpoph")); //cachele
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
</body>
</html>
