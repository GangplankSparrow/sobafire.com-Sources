<div align="center">
	<%INFOAREA%>
	<div id="result"></div>
	<form id="form" action="#" method="POST">
		
		Build adını girin,<br>
		-60 karakterden uzun yazı girerseniz hata alabilirsiniz.<br><br>
		<input type="text" class="input" name="build_adi" id="build_adi" size="30" placeholder="Build adını yazın..."></input>
		<br><br>
		
		Hangi karakter için build oluşturacaksınız? Listeden seçin,<br><br> 
		<select name="champions" class="input" style="width: 220px;">
			<%SELECT_CHARACTERS%>
		</select>
	<br><br>
		
	<button id="doStep1" class="ui-button button1"> 
		<span class="button-left">
			<span class="button-right">2. adıma geç...</span>
		</span>
	</button>
	</form>
</div>