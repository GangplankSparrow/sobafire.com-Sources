<div align="center">
	<%INFOAREA%>
	<div id="result"></div>
	<form id="form" action="#" method="POST">
	
	Giriş-Gelişme-Sonuç yazılarınızı yazın;<br><br> 
		<h3>Giriş Bölümü</h3>
		-Bu bölümde genellikle seçilen karakterin artıları ve eksilerinden bahsedilir, kısaca bilgi verilir.<br>
		-Jungle yapılıyorsa hangi yolun izleneceği vb. tarzda yazılar yazılır.<br>
		<textarea class="bbcode_enabled" class="input" type="text" rows="10" cols="60" name="icerik1"></textarea><br><br>
		
		<h3>Gelişme Bölümü</h3>
		-Bu bölümde genellikle oyun ortasındaki rolünüz hakkında bilgi verilir.<br>
		-Karakterin ana itemleri yazılır ve bu itemlerin neden alındığı hakkında bilgi verilir.<br>
		<textarea class="bbcode_enabled2" class="input" type="text" rows="10" cols="60" name="icerik2"></textarea><br><br>
		
		<h3>Sonuç Bölümü</h3>
		-Bu bölümde bahsetmek istediğiniz herşeyi yazabilirsiniz. Tamamen size kalmış!<br>
		<textarea class="bbcode_enabled3" class="input" type="text" rows="10" cols="60" name="icerik3"></textarea><br><br>
		
		
		Herşey tamam mı? <br>
		Herşey tamamsa, butona tıklayarak buildinizi ekleyin.
		
	<br><br>
	<button id="doStep7" class="ui-button button1"> 
		<span class="button-left">
			<span class="button-right">Buildimi bitir ve paylaş!</span>
		</span>
	</button>
	</form>
</div>

<!-- BBCode -->
<script type="text/javascript" src="<%THEME%>js/jquery.bbcode.js"></script>
<script type="text/javascript">
	$(document).ready(function()
	{
		$(".bbcode_enabled").each(function () {	
			$(this).bbcode({
				tag_bold:true,
				tag_italic:true,
				tag_underline:true,
				tag_link:true,
				tag_item:true,
				tag_skill:true,
				tag_own3d:true,
				tag_youtube:true,
				tag_twitch:true,
				tag_color:false,
				tag_image:true,
				button_image:true
			});
		});
	});
</script>