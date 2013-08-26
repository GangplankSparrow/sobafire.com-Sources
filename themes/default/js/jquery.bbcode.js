(function($){
  $.fn.bbcode = function(options){
		// default settings
    var options = $.extend({
      tag_bold: true,
      tag_italic: true,
      tag_underline: true,
      tag_link: true,
	  tag_item: true,
	  tag_skill:true,
	  tag_youtube:true,
	  tag_twitch:true,
	  tag_color:true,
	  tag_own3d:true,
      tag_image: false,
      button_image: true,
      image_url: "http://www.sobafire.com/themes/default/images/bbimage/"
    },options||{});
	
    //  panel 
    var text = '<div id="bbcode_bb_bar">'
    if(options.tag_bold){ // [b]
      text = text + '<a href="#" id="b" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'bold.png" />';
      }else{
        text = text + 'Bold';
      }
      text = text + '</a>';
    }
    if(options.tag_italic){ // [i]
      text = text + '<a href="#" id="i" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'italic.png" />';
      }else{
        text = text + 'Italic';
      }
      text = text + '</a>';
    }
    if(options.tag_underline){ // [u]
      text = text + '<a href="#" id="u" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'underline.png" />';
      }else{
        text = text + 'Undescore';
      }
      text = text + '</a>';
    }
    if(options.tag_link){ // [link]
      text = text + '<a href="#" id="link" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'link.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
	if(options.tag_item){ // [item]
      text = text + '<a href="#" id="item" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'item.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
	if(options.tag_own3d){ // [own3d]
      text = text + '<a href="#" id="own3d" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'own3d.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
	if(options.tag_youtube){ // [youtube]
      text = text + '<a href="#" id="youtube" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'youtube.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
	if(options.tag_twitch){ // [twitch]
      text = text + '<a href="#" id="twitch" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'twitch.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
	if(options.tag_color){ // [color]
      text = text + '<a href="#" id="color" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'color.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
	if(options.tag_skill){ // [skill]
      text = text + '<a href="#" id="skill" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'skill.png" />';
      }else{
        text = text + 'Link';
      }
      text = text + '</a>';
    }
    if(options.tag_image){ //image
      text = text + '<a href="#" id="image" title="">';
      if(options.button_image){
        text = text + '<img src="' + options.image_url + 'image.png" />';
      }else{
        text = text + 'Image';
      }
      text = text + '</a>';
    }
    text = text + '</div>';
    
	//kontroller
    $(this).wrap('<div id="bbcode_container"></div>');
    $("#bbcode_container").prepend(text);
    $("#bbcode_bb_bar a img").css("border", "none");
    var id = '#' + $(this).attr("id");
    var e = $(id).get(0);
    
    $('#bbcode_bb_bar a').click(function() {
      var button_id = $(this).attr("id");
      var start = '['+button_id+']';
      var end = '[/'+button_id+']';

	  var param="";
	  if (button_id=='image')
	  {
	     param=prompt("Resim linkini yazın","http://");
		 if (param)
			start = '[image]' + param;
		 }
	  else if (button_id=='link')
	  {
			param=prompt("Linki yazın","http://");
			if (param) 
				start = '[link]' + param;
	  }
	  else if (button_id=='item')
	  {
			param=prompt("İtem adını yazın","");
			if (param) 
				start = '[item]' + param;
	  }
	  else if (button_id=='skill')
	  {
			param=prompt("Skill adını yazın","");
			if (param) 
				start = '[skill]' + param;
	  }
	  else if (button_id=='own3d')
	  {
			param=prompt("own3d.tv video ID'sini yazın.\nÖrneğin: 360272 gibi. Video ID'si linkte görünür.","");
			if (param) 
				start = '[own3d]' + param;
	  }
	  else if (button_id=='youtube')
	  {
			param=prompt("Youtube linkinin tam adresini yazın (www.youtube.com silmeden)","");
			if (param) 
				start = '[youtube]' + param;
	  }
	  else if (button_id=='twitch')
	  {
			param=prompt("Twitch.tv linkini yazın","");
			if (param) 
				start = '[twitch]' + param;
	  }
      insert(start, end, e);
      return false;
    });
	}
	
	function insert(start, end, element) {
    if (document.selection) {
       element.focus();
       sel = document.selection.createRange();
       sel.text = start + sel.text + end;
    } else if (element.selectionStart || element.selectionStart == '0') {
       element.focus();
       var startPos = element.selectionStart;
       var endPos = element.selectionEnd;
       element.value = element.value.substring(0, startPos) + start + element.value.substring(startPos, endPos) + end + element.value.substring(endPos, element.value.length);
    } else {
      element.value += start + end;
    }
  }
})(jQuery)