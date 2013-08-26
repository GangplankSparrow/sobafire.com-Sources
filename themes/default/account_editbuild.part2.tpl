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
	<form id="form" action="?page=account&s=editbuild&buildID=<%BUILD_ID%>&act=2" method="POST">
		
		Summoner spellerinizi seçin ve düzenleyin,<br><br> 
		1. summoner: <select name="summoner1">
			<%SELECT_SUMMONERS%>
		</select><br>
		
		2. summoner: <select name="summoner2">
			<%SELECT_SUMMONERS%>
		</select><br>
	<input type="submit" name="submit" id="submit" value="Düzenle"></input>
	</form>
</div>