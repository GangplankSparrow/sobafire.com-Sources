<div align="center">
	<%INFOAREA%>
	<div id="result"></div>
	<form id="form" action="#" method="POST">
		
	<b>Önemli:</b>Runelerinizi seçerken şuna dikkat edin:<br>
	<ul>
		<li>-Toplam rune sayısı Quint'ler için 3, diğer runeler için maksimum 9'dur.</li>
		<li>-Eğer 2 adet rune girerseniz, rune sayılarının toplamı baz alınır. (2+1=3 şeklinde) </li>
		<li>-Eğer ek rune istemiyorsanız, orayı boş bırakın.</li>
	<br>
	
	Runelerinizi oluşturun,<br><br>
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
		
	<br><br>
	<button id="doStep4" class="ui-button button1"> 
		<span class="button-left">
			<span class="button-right">5. adıma geç...</span>
		</span>
	</button>
	</form>
</div>