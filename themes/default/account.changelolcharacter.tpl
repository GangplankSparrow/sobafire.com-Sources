<form action="<%SITE_ADDR%>?page=account&s=changelolcharacter" method="POST">
	
	Bu sayfada LOL karakterinizi Sobafire.com üyeliğinize bağlayabilirsiniz. <br>
	Üyeliğinizi bağladığınız takdirde elo puanınız, win/loss durumunuz gibi bilgiler diğer üyelere görünür olacaktır.<br>
	Daha önce bir karakter bağladıysanız, karakter güncellenecektir.
	<br><br>
	
	LOL Summoner adınızı yazın,
	<br><input type="text" name="summoner_name"></input>
	<br><br>
	Sunucunuzu seçin,<br>
	<input type="radio" name="server" value="1">EU East & Nordic<br>
	<input type="radio" name="server" value="2">EU West<br>
	<input type="radio" name="server" value="3">USA<br>
	
	<br>
	<input type="submit" id="submit" name="submit" value="Kaydet"></input>
</form>