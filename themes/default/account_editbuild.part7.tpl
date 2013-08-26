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
	<form id="form" action="?page=account&s=editbuild&buildID=<%BUILD_ID%>&act=7" method="POST">
	
	Giriş-Gelişme-Sonuç yazılarınızı düzenleyin;<br><br> 
		<h3>Giriş Bölümü</h3>
		-Bu bölümde genellikle seçilen karakterin artıları ve eksilerinden bahsedilir, kısaca bilgi verilir.<br>
		-Jungle yapılıyorsa hangi yolun izleneceği vb. tarzda yazılar yazılır.<br>
		<textarea id="bbcode_enabled" type="text" rows="10" cols="60" name="icerik1"><%ACCOUNT_EDITBUILD_ICERIK1_VALUE%></textarea><br><br>
		
		<h3>Gelişme Bölümü</h3>
		-Bu bölümde genellikle oyun ortasındaki rolünüz hakkında bilgi verilir.<br>
		-Karakterin ana itemleri yazılır ve bu itemlerin neden alındığı hakkında bilgi verilir.<br>
		<textarea type="text" rows="10" cols="60" name="icerik2"><%ACCOUNT_EDITBUILD_ICERIK2_VALUE%></textarea><br><br>
		
		<h3>Sonuç Bölümü</h3>
		-Bu bölümde bahsetmek istediğiniz herşeyi yazabilirsiniz. Tamamen size kalmış!<br>
		<textarea type="text" rows="10" cols="60" name="icerik3"><%ACCOUNT_EDITBUILD_ICERIK3_VALUE%></textarea><br><br>
		
	<br><br>
	<input type="submit" name="submit" id="submit" value="Düzenle"></input>
	</form>
</div>

<!-- BBCode -->
<script type="text/javascript" src="<%THEME%>js/jquery.bbcode.js"></script>
<script type="text/javascript">
  $(document).ready(function()
  {
	$("#bbcode_enabled").bbcode({
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
</script>