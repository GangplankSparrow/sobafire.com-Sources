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
	<form id="form" action="?page=account&s=editbuild&buildID=<%BUILD_ID%>&act=3" method="POST">
		
	<b>Dikkat:</b> Skill sıranız şu şekilde olmalıdır:<br>
	<ul>
		<li>Tüm Karakterler (Udyr ve Karma Hariç): 5Q, 5W, 5E, 3R</li>
		<li>Karma: 6Q, 6W, 6E</li>
		<li>Udyr: Her skill için maksimum 5 tane. (Mesela 4Q, 5W, 5E, 4R)</li>
	</ul>
	<br><br>
	Şimdi skill sıranızı oluşturun ve düzenleyin,<br><br>

		<%SELECT_SKILLS%>
		
	<br>
	<input type="submit" name="submit" id="submit" value="Değiştir"></input>
	</form>
</div>