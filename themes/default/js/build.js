$(".disabled").each(function() {
			$(this).attr("title",$(this).siblings("img").attr("title"));
		});
		
		$.ajaxSetup ({ cache: false }); 
		function getData(t,c0,c1) {
			$("#"+t).load("http://www.sobafire.com/?page=ajax", {'c0': c0, 'c1': c1,}, 
			function(response, status, xhr) {
				if (status=="error") {
					$("#"+t).html($("#poperr").html());
				}
				
				$("#pop").html($("#"+t).html());
				kgo();
			});
		}

		$(".guideSilver img").each(function(){
			$(this).data("title",$(this).attr("title")).removeAttr("title");
			
			if ($(this).data("title")!="") 
			{
				var c=$(this).data("title");
				var cs=c.split("http://www.sobafire.com/");
				var c0=cs[0].replace(/[\W]/g,"");
				$(this).data("cx0",cs[0]);

				if (c0=="items") {
					var c1=c.substr(cs[0].length+1).replace(/[\W\d]/g,"");
					$(this).data("cx1",c.substr(cs[0].length+1).replace(/["'\s\d]/g,""));
				}
				else {
					var c1=c.substr(cs[0].length+1).replace(/[\W]/g,"");
					$(this).data("cx1",c.substr(cs[0].length+1).replace(/["'\s]/g,""));
				}
				
				$(this).data("c0",c0);
				$(this).data("c1",c1);
			}
		});
		$(".guideSilver img").load(function(){
			if ($(this).attr("width")+"px"==$(this).css("max-width")) {
				$(this).wrap('<a href="'+$(this).attr("src")+'" title="View full image"></a>');
			}
		});
		
		var mymousex;
		var mymousey;
		
		function kgo() {
			var offset = $(".guideSilver").offset();
			var maxx=offset.left+$(".guideSilver").outerWidth();
			var maxy=$("#bottomlimit").offset().top-10;

			myy=mymousey+15;
			myx=mymousex-($("#pop").width()/2)-20;
			
			if (myx<offset.left+1)
				myx=offset.left+1;
			if (myx>maxx-($("#pop").outerWidth())-1)
				myx=maxx-($("#pop").outerWidth())-1;
			if (myy>maxy-($("#pop").outerHeight())) {
				myy=mymousey-$("#pop").outerHeight()-15;
			}					
			
			$("#pop").css({
				left: myx + "px",
				top: myy + "px"
			});
		}
		
		
		$(".guideSilver img").mousemove(function(e){
			mymousex=e.pageX;
			mymousey=e.pageY;

			var c0=$(this).data("c0");
			var c1=$(this).data("c1");
			
			if (!c0) return;
			
			if (c0!="custom" && c1) {
				var c2="dpoph_"+c0+"_"+c1;
				if (!$("#"+c2).length) {
					$('<div id="'+c2+'" style="display: none">'+c2+'</div>').appendTo($("#dpoph"));
					$("#"+c2).html($("#dpophloading").html());
					
					getData(c2,$(this).data("cx0"),$(this).data("cx1"));
				}

				$("#pop").html($("#"+c2).html());
				$("#pop").show();
				kgo();
			}
			else if (c0!="custom") {
				var c2="dpoph_"+c0;
				if (!$("#"+c2).length) {
					$('<div id="'+c2+'" style="display: none">'+c2+'</div>').appendTo($("#dpoph"));
					$("#"+c2).html($("#dpophloading").html());
					
					getData(c2,"masteries",$(this).data("cx0"));
				}

				$("#pop").html($("#"+c2).html());
				$("#pop").show();
				kgo();
			}
		});
		
		$(".guideSilver img").mouseout(function(e){
			$("#pop").hide();
		});