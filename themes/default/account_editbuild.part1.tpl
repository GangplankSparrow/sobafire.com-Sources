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
	<form id="form" action="?page=account&s=editbuild&buildID=<%BUILD_ID%>&act=1" method="POST">
		
		Build adını düzenleyin,<br>
		-60 karakterden uzun yazı girerseniz hata alabilirsiniz.<br><br>
		<input type="text" name="build_adi" id="build_adi" size="60" value="<%BUILDEDIT_CURRENT_BUILD_NAME%>"></input>
		<br><br>
		
		Karakterinizi düzenleyin, (değiştirmek istemiyorsanız eski karakterinizi seçin)<br><br> 
		<select name="champions">
			<%SELECT_CHARACTERS%>
		</select>
		
	<br><br>
	<input type="submit" name="submit" id="submit" value="Değiştir"></input>
	</form>
</div>