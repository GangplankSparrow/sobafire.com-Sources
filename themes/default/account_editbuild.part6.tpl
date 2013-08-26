<link rel="stylesheet" href="<%THEME%>css/builds.css" type="text/css" media="screen" title="no title" charset="utf-8" />

<script src="http://code.jquery.com/jquery-latest.pack.js" type="text/javascript"></script>
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
	<form id="form" action="?page=account&s=editbuild&buildID=<%BUILD_ID%>&act=6" method="POST">
		
	İtemlerinizi düzenleyin,<br><br> 
		<h3>Oyun Başı</h3>
		-Oyunun başında maksimum 450 altın (support iseniz 490 altın) ile başlayabilirsiniz.<br>
		-Bu fiyattan yüksek itemleri seçtiğiniz takdirde sistem bunu kabul etmeyecektir.<br>
		1. item: <select id="item_early1" name="item_early1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		2. item: <select id="item_early2" name="item_early2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		3. item: <select id="item_early3" name="item_early3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		4. item: <select id="item_early4" name="item_early4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		5. item: <select id="item_early5" name="item_early5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		6. item: <select id="item_early6" name="item_early6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br><br>
		
		<h3>Oyun Ortası</h3>
		-Oyunun ortasında ortalama 2500-3500g kadar para kazanmış olursunuz.<br>
		-Bu bölümde istediğiniz itemleri kullanabilirsiniz, ancak 3500g'yi geçmemeye çalışın.<br>
		1. item: <select id="item_mid1" name="item_mid1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		2. item: <select id="item_mid2" name="item_mid2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		3. item: <select id="item_mid3" name="item_mid3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		4. item: <select id="item_mid4" name="item_mid4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		5. item: <select id="item_mid5" name="item_mid5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		6. item: <select id="item_mid6" name="item_mid6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br><br>
		
		<h3>Oyun Sonu</h3>
		-Burada oyunun sonunda tamamlayacağız tam buildi seçin.<br>
		-İstediğiniz itemleri seçebilirsiniz, bu sizin son buildinizdir ve tüm itemler dahildir.<br>
		1. item: <select id="item_late1" name="item_late1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		2. item: <select id="item_late2" name="item_late2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		3. item: <select id="item_late3" name="item_late3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		4. item: <select id="item_late4" name="item_late4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		5. item: <select id="item_late5" name="item_late5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		6. item: <select id="item_late6" name="item_late6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select>
		
	<br><br>
	<input type="submit" name="submit" id="submit" value="Devam et..."></input>
	</form>
</div>
<br><br>
<div align="center">Aldığınız itemler sitede şu şekilde görünecek;</div><br>
<table style="width: 300px;">
<tr>
	<td style="width: 100px;">
		Oyun başı itemleri<br>
		<div id="result_item_early1"></div>
		<div id="result_item_early2"></div>
		<div id="result_item_early3"></div>
		<div id="result_item_early4"></div>
		<div id="result_item_early5"></div>
		<div id="result_item_early6"></div>
	</td>
	<td style="width: 100px;">
		Oyun ortası itemleri<br>
		<div id="result_item_mid1"></div>
		<div id="result_item_mid2"></div>
		<div id="result_item_mid3"></div>
		<div id="result_item_mid4"></div>
		<div id="result_item_mid5"></div>
		<div id="result_item_mid6"></div>
	</td>
	
	<td style="width: 100px;">
		Oyun sonu itemleri<br>
		<div id="result_item_late1"></div>
		<div id="result_item_late2"></div>
		<div id="result_item_late3"></div>
		<div id="result_item_late4"></div>
		<div id="result_item_late5"></div>
		<div id="result_item_late6"></div>
	</td>
</tr>
</table>


<script type="text/javascript">
$('select[name^="item_early"]').change( function() {
    var $this = $(this);
    var value = $this.val();
    var $resultDiv = $('#result_' + $this.attr('name'));
    //directly set loading value as html
    $resultDiv.html('<img src="http://www.sobafire.com/themes/default/images/loading.gif">');

    //change image url source from server (expected return value is something like <img src="" />
    $resultDiv.load('http://www.sobafire.com/?page=ajax&ajaxType=ITEM&itemID=' + value);
});

$('select[name^="item_mid"]').change( function() {
    var $this = $(this);
    var value = $this.val();
    var $resultDiv = $('#result_' + $this.attr('name'));
    //directly set loading value as html
    $resultDiv.html('<img src="http://www.sobafire.com/themes/default/images/loading.gif">');

    //change image url source from server (expected return value is something like <img src="" />
    $resultDiv.load('http://www.sobafire.com/?page=ajax&ajaxType=ITEM&itemID=' + value);
});

$('select[name^="item_late"]').change( function() {
    var $this = $(this);
    var value = $this.val();
    var $resultDiv = $('#result_' + $this.attr('name'));
    //directly set loading value as html
    $resultDiv.html('<img src="http://www.sobafire.com/themes/default/images/loading.gif">');

    //change image url source from server (expected return value is something like <img src="" />
    $resultDiv.load('http://www.sobafire.com/?page=ajax&ajaxType=ITEM&itemID=' + value);

});
</script>