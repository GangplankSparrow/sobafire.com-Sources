//Make it, as soon as the page is fully loaded
        //check the anchor (# of the page) every 90milliseconds
        $().ready(function(){
          setInterval("checkAnchor()", 90);
        });
		
        var imgloader = "./themes/default/images/loading.gif";
		var imgNavloader = "./themes/default/images/loading-navigation.gif";
		
        //The div wherein the ajax-loaded content should be put
        var div = "#content";
        //No anchor is specified, yet.
        var currentAnchor = null;
        //The Function to check the anchor and possibly load the ajax content
        function checkAnchor()
        {
          //Check if the variable currentAnchor does not match
          //the Current anchor (# of the page), if that is the case
          //it means that the user must have clicked a link

          if(currentAnchor != document.location.hash){
            //Set the variable currentAnchor to the anchor now toggled
            currentAnchor = document.location.hash;
            //If currentAnchor is false or 0, return so that no ajax is used wrongly
            if(!currentAnchor)
              return;
            else
            {
			  //fix bug
			  var url = currentAnchor.split("#").join("");
              //Replace the anchor's ! with a ./ so that you can make an actual url of it
              url = url.split("!").join("./");
             
			  //If we're looking below, slide us to top
			  if ($(this).scrollTop() > 160) 
			  {
				 $("html, body").animate({ scrollTop: 161 }, 600);
			  }
			  
			  //Make the Div which will receive the content Invisible (with an animation - slide it to top)
              $(div).html('<div id="content"><img src="' + imgloader + '" alt="" /></div>');
			  $('#loading-area').html('<img src="' + imgNavloader + '" alt="" />');
              //Start the ajax request
              $.ajax({
                url: url + '?module=ajax',

                success:
                  function(data)
                  {
                    //Put the returned string into the div
                    $(div).html(data);
					$('#loading-area').html('');
                  },

              });
            }

          }
        }