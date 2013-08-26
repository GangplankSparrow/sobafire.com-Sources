<div align="center">
	<%INFOAREA%>
	<div id="result"></div>
	<form id="form" action="#" method="POST">
		
	İtemlerinizi seçin,<br><br> 
		<h3>Oyun Başı</h3>
		-Oyunun başında maksimum 450 altın (support iseniz 490 altın) ile başlayabilirsiniz.<br>
		-Bu fiyattan yüksek itemleri seçtiğiniz takdirde sistem bunu kabul etmeyecektir.<br>
		1. item: <select class="input" name="item_early1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		2. item: <select class="input" name="item_early2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		3. item: <select class="input" name="item_early3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		4. item: <select class="input" name="item_early4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		5. item: <select class="input" name="item_early5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br>
		6. item: <select class="input" name="item_early6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS_EARLY%>
		</select><br><br>
		
		<h3>Oyun Ortası</h3>
		-Oyunun ortasında ortalama 2500-3500g kadar para kazanmış olursunuz.<br>
		-Bu bölümde istediğiniz itemleri kullanabilirsiniz, ancak 3500g'yi geçmemeye çalışın.<br>
		1. item: <select class="input" name="item_mid1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		2. item: <select class="input" name="item_mid2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		3. item: <select class="input" name="item_mid3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		4. item: <select class="input" name="item_mid4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		5. item: <select class="input" name="item_mid5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		6. item: <select class="input" name="item_mid6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br><br>
		
		<h3>Oyun Sonu</h3>
		-Burada oyunun sonunda tamamlayacağız tam buildi seçin.<br>
		-İstediğiniz itemleri seçebilirsiniz, bu sizin son buildinizdir ve tüm itemler dahildir.<br>
		1. item: <select class="input" name="item_late1">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		2. item: <select class="input" name="item_late2">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		3. item: <select class="input" name="item_late3">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		4. item: <select class="input" name="item_late4">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		5. item: <select class="input" name="item_late5">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select><br>
		6. item: <select class="input" name="item_late6">
		<option value="0">Seçiniz...</option>
			<%SELECT_ITEMS%>
		</select>
		
	<br><br>
	<button id="doStep6" class="ui-button button1"> 
		<span class="button-left">
			<span class="button-right">7. adıma geç...</span>
		</span>
	</button>
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