<script type="text/javascript">
	$(document).ready(function()
	{
		 $("#chatpanel .subpanel a").click(function() 
		 {
			var chatterNickname = $(this).text();
			var connectionStatus = "Bağlanıyor...";
			var lastMessage;
			
			if(!$("#singlechatpanel-1").is(':visible'))
			{
				$("#singlechatpanel-1").css({'display':'block'});
				$("#singlechatpanel-1 #chatter-nickname-1").html(chatterNickname);
				$("#singlechatpanel-1 #singlechat-top").html("You're talking to " + chatterNickname + " right now.");
				$("#singlechatpanel-1 #singlechat-conn-status").html("Connection status: <b>Connecting...</b>");
				
				setInterval(function() 
				{
					$.getJSON('./chatServer.php', function(JsonReply) 
					{
						
						if(JsonReply.connectionStatus == true)
						{
							connectionStatus = 'Connected!';
						}
						else
						{
							connectionStatus = "Connecting...";
						};
						$("#singlechatpanel-1 #singlechat-conn-status").html("Connection status: <b>" + connectionStatus + "</b>");
						
						if(JsonReply.message != lastMessage)
						{
							$("#singlechatpanel-1 .subpanel ul").append('<li><span><img src="./images/chat-thumb.gif"/>' + chatterNickname + ': ' + JsonReply.message + '</span></li>');
							lastMessage = JsonReply.message;
						};
					})
				}, 3000);
			}
			
			else if(!$("#singlechatpanel-2").is(':visible'))
			{
				$("#singlechatpanel-2").css({'display':'block'});
				$("#singlechatpanel-2 #chatter-nickname-2").html(chatterNickname);
			}
			
			else if(!$("#singlechatpanel-3").is(':visible'))
			{
				$("#singlechatpanel-3").css({'display':'block'});
				$("#singlechatpanel-3 #chatter-nickname-3").html(chatterNickname);
			}
			else 
			{
				alert("Out of rooms.");
			};
		 });
		 
		 // Formlar
		 $("#singlechatpanel-1 #sendMessage").click(function()
		 {
			$("#singlechatpanel-1 .subpanel ul").append('<li><span><img src="./images/chat-thumb.gif"/>Aristona: Test message.</span></li>');
		 });
		
	});
	</script>
	
	<div id="footpanel">
    <ul id="mainpanel"> 
		<li><a href="<%SITE_ADDR%>#!" class="home">Index<small>Index</small></a></li>
		<li><a href="#" id="switchRegisterModal" class="user_add">Register<small><:NAV_REGISTER:></small></a></li>
		<li><a href="<%SITE_ADDR%>#!profilim.html" class="editprofile">Profilim<small>Profilim</small></a></li>
		<li><a href="<%SITE_ADDR%>#!oyuncu-listesi.html" class="profile">Oyuncular<small>Oyuncular</small></a></li>
		<li><a href="<%SITE_ADDR%>#!sobafire_sponsorluk.html" class="gold">Sponsorluk<small>Sponsorluk</small></a></li>
		<li><a href="#" class="messages">Forum<small>Forum</small></a></li>
		<li><a href="http://www.facebook.com/sobafire" target="_blank" class="facebook">Facebook <small>Facebook</small></a></li>
		
		
		<li id="alertpanel">
			<a href="#" class="alerts">Bildirimler</a>
			<div class="subpanel">
				<ul>
					<li class="view"><a href="#"><:VIEW_ALL:></a></li>
					<li><a href="#" class="delete">X</a><a href="#">Anlık Bildirimler</a>
						<div style="color: #333333;">
							
							<script type="text/javascript">
							
							var loading = '<img src="./themes/default/images/loading.gif" width="120" height="auto">';

							$(document).ready( function() 
							{
								$('.delete').click( function()
								{
									$('.cometarea').hide();
									$('.cometarea').html("Siliniyor...<br>" + loading).fadeIn("slow");
									$('.cometarea').fadeOut("slow");
									$('.cometarea').show();
									
								});
							});
							</script>
			
							<div id="cometarea" class="cometarea" overflow="scroll">
								
							</div>
						</div>
					</li>
				</ul>
			</div> 
		</li>
        <li id="chatpanel">
        	<a href="#" class="chat">Online Kullanıcı (0)</a>
				<!--<strong><%TOTALONLINE%></strong> -->
            <div class="subpanel">
            <ul>
				<@CHAT@>
                <!--<%ONLINECHAT%> -->
            </ul>
            </div>
        </li>
		
		<!-- Chat 1 -->
		<li id="singlechatpanel-1" style="display: none;">
        	<a href="#" class="chat">
				<div id="chatter-nickname-1"></div>
			</a>
            <div class="subpanel" style="width: 371px;">
				<div id="singlechat-top" style="background-color: #444444;"></div>
				<div id="singlechat-conn-status" style="background-color: #444444;"></div>
				<ul>
				</ul>
				
				<div class="form-background" style="background-color: #444444;">
					<form id="chatform-1">
						<input type="text" id="message" name="message" size="59"><br>
						<input type="button" id="sendMessage" value="Send Message">
					</form>
				</div>
				<br>
            </div>
        </li>
		
		<!-- Chat 2 -->
		<li id="singlechatpanel-2" style="display: none;">
        	<a href="#" class="chat">
				<div id="chatter-nickname-2"></div>
			</a>
            <div class="subpanel" style="width: 371px;">
				<div id="singlechat-top" style="background-color: #e3e2e2;"></div>
				<ul>
				
				</ul>
				
				<form id="chatform-2">
					<input type="text" id="message" name="message"><br>
					<input type="button" id="sendMessage" value="Send Message">
				</form>
            </div>
        </li>
		
		<!-- Chat 3 -->
		<li id="singlechatpanel-3" style="display: none;">
        	<a href="#" class="chat">
				<div id="chatter-nickname-3"></div>
			</a>
            <div class="subpanel" style="width: 371px;">
				<div id="singlechat-top" style="background-color: #e3e2e2;"></div>
				<ul>
				
				</ul>
				
				<form id="chatform-3">
					<input type="text" id="message" name="message"><br>
					<input type="button" id="sendMessage" value="Send Message">
				</form>
            </div>
        </li>
	</ul>
</div>

<a href="#" class="scrollup">Scroll</a>