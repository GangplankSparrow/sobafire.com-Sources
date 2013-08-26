jQuery(function ($) {
/* 
	---------------- Login Form ve Modalları ---------------- 
*/
	$('a#switchLoginModal').each(function() {
		$(this).click(function(e) {
			$.modal.close();
			$('#login-content').modal({ opacity:80 });
			return false;
		});
	});
	
	//Login formuna tıklandığındaki olaylar
	$("#doLogin").click(function(e) {
        e.preventDefault();
		$("#login-result").html('<img src="<%THEME%>images/loading.gif">');
        var formData = $("#loginForm").serialize();
        $.post("?page=login", formData, function(response)
		{
			if(response.status == 'success')
			{	
				$.modal.close();
				location.reload();
			}
			else
			{
				$("#login-result").addClass('login-error');
				$("#login-result").html(response.error_message);
			}
        },'json');
    });

/* 
	---------------- Register Form ve Modalları ---------------- 
*/
	$('a#switchRegisterModal').each(function() {
		$(this).click(function(e) {
			$.modal.close();
			$('#register-content').modal({ opacity:80 });
			return false;
		});
	});
	
	//Register formuna tıklandığındaki olaylar
	$("#doRegister").click(function(e) {
        e.preventDefault();
		$("#register-result").html('<img src="<%THEME%>images/loading.gif">');
        var formData = $("#registerForm").serialize();
        $.post("?page=register", formData, function(response)
		{
			if(response.status == 'success')
			{	
				$.modal.close();
				$('#register-success').modal({ opacity:80 });
			}
			else
			{
				$("#register-result").addClass('register-error');
				$("#register-result").html(response.error_message);
			}
        },'json');
    });

/* 
	---------------- Logout Form ve Modalları ---------------- 
*/
	$('a#switchLogoutModal').each(function() {
		$(this).click(function(e) {
			$.modal.close();
			$('#logout-content').modal({ opacity:80 });
			return false;
		});
	});
	
	$("#doLogout").click(function(e) {
		$.get("?page=logout", function(response)
		{
			$.modal.close();
			location.reload();
        });
    });
	
/* 
	---------------- Contact Formu ---------------- 
	Responseler için response-error ve response-success kullan
*/
	 $(document).delegate("button#doContact", "click", function(e){
        e.preventDefault();
		$("#contact-result").html('<img src="./themes/default/images/loading.gif" style="width: auto; height: 15px;">');
		$("#contact-result").addClass('response-error');
		$("#contact-result").html('Bu form daha hazırlanmadı');
		
		/*var formData = $("#contactForm").serialize();
        $.post("?page=contact", formData, function(response)
		{
			if(response.status == 'success')
			{	
				$("#contact-result").addClass('response-success');
				$("#contact-result").html(response.error_message);
			}
			else
			{
				$("#contact-result").addClass('response-error');
				$("#contact-result").html(response.error_message);
			}
        },'json'); */
    });
	
/*
    ------------------------------------------------------------------------------------------------
	-- Right_content Şampiyon Arama Scripti ----------------------------------------------------------------
	------------------------------------------------------------------------------------------------
*/

	$(document).delegate("input#search-champions", "keyup", function(e){
		var $content = $('.search-champions-list li');
		var textboxVal = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
		
		if(textboxVal == "")
		{
			$('.search-champions-area').css('visibility', 'hidden');
			return;
		}
		else
		{
			$('.search-champions-area').css('visibility', 'visible');
			$content.show().filter(function() {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(textboxVal);
			}).hide();
			return;
		}
	});

/*
    ------------------------------------------------------------------------------------------------
	-- Build Oluşturma Ajax Desteği ----------------------------------------------------------------
	------------------------------------------------------------------------------------------------
*/
	
	//Step 1
	$("#doStep1, #doStep2, #doStep3, #doStep4, #doStep5, #doStep6, #doStep7").click(function(e) {
        e.preventDefault();
		$("#result").html('<img src="./themes/default/images/loading.gif">');
        var formData = $("#form").serialize();
		
		$.post("?page=account&s=createbuild", formData, function(response)
		{
			if(response.indexOf("success") != -1)
			{
				location.reload();
			}
			else
			{
				$("#result").html(response);
			}
        }); 
    });

	
	
//jquery bitiş
});