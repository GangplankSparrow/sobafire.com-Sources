Yorumunuzu ekleyin? (<%USERNAME%> olarak giriş yaptınız.)

<form action="<%SITE_ADDR%>?page=account&s=postcomment&on=News&newID=<%HABER_FIXED_ID%>" method="POST">

	<textarea id="bbcode_enabled" name="yorum" rows="7" cols="85"></textarea>
	<br><br>
	<input type="submit" name="submit" id="submit" value="Yorumumu Gönder"></input>
</form>

<!-- BBCode -->
<script type="text/javascript" src="<%THEME%>js/jquery.bbcode.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
	$("#bbcode_enabled").bbcode({
		tag_bold:true,
		tag_italic:true,
		tag_underline:true,
		tag_link:true,
		tag_item:false,
		tag_skill:false,
		tag_own3d:false,
		tag_youtube:false,
		tag_twitch:false,
		tag_color:false,
		tag_image:true,
		button_image:true
		});});
</script>