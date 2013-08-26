<div align="center">
	<%INFOAREA%>
	<div id="result"></div>
	<form id="form" action="#" method="POST">
		
		Summoner spellerinizi seçin,<br><br> 
		1. summoner: <select name="summoner1" class="input" style="width: 230px;">
			<%SELECT_SUMMONERS%>
		</select><br><br>
		
		2. summoner: <select name="summoner2" class="input" style="width: 230px;">
			<%SELECT_SUMMONERS%>
		</select><br>
	<button id="doStep2" class="ui-button button1"> 
		<span class="button-left">
			<span class="button-right">3. adıma geç...</span>
		</span>
	</button>
	</form>
</div>