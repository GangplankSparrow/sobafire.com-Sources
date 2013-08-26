<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
	<meta http-equiv="content-type" content="text/html;charset=UTF-8">
	<title><%TITLE%></title>	
	<META NAME="description" CONTENT="<%DESCRIPTION%>">
	<META NAME="keywords" CONTENT="<%KEYWORDS%>">
	<meta name="alexaVerifyID" content="exyxepW0BjfusgxUADFH5wLnRo8" />
	
	<link rel="stylesheet" href="<%THEME%>css/sobafire.css" type="text/css" />
	<link rel="stylesheet" href="<%THEME%>css/champs.css" type="text/css" />
	<link rel="stylesheet" href="<%THEME%>css/development.css" type="text/css" />
	<link rel="stylesheet" href="<%THEME%>css/bottom.css" type="text/css" />
	<link rel="stylesheet" href="<%THEME%>css/tournament.css" type="text/css" />
	<link rel="stylesheet" href="<%THEME%>css/simplemodal.css" type="text/css" />
	<link rel="stylesheet" href="<%THEME%>css/builds.css" type="text/css" />
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:600&subset=latin,latin-ext,cyrillic-ext,greek-ext,greek,vietnamese,cyrillic' rel='stylesheet' type='text/css'>
	
	<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js?ver=1.6.2'></script>
	<script type="text/javascript" src="<%THEME%>js/ajax.js"></script>
	<script type="text/javascript" src="<%THEME%>js/bottombar.js"></script>
	<script type="text/javascript" src="<%THEME%>js/jquery.simplemodal.js"></script>
	<script type="text/javascript" src="<%THEME%>js/development.js"></script>
	
	<!-- Google Analytics Code -->
	<script type="text/javascript">var _gaq = _gaq || []; _gaq.push(['_setAccount', 'UA-27671208-2']); _gaq.push(['_trackPageview']); (function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script>
</head>

<body class="bg<%BG_ID%>">

	<@NAVIGATION@>
	
	<!-- wrapper -->
	<div id="wrapper">
		
		
		<!-- nav -->
		<@HEADER@>
		<!-- mid -->
		<div id="mid">
			<div id="mid-inner">
				<div id="content"> <!-- bu burada kalacak!! -->
					<%CONTENT%>
				</div>
				<!-- sidebar-right -->
				<@RIGHT_CONTENT@>
				<!-- /sidebar-right -->
			</div>
		</div>
		<!-- /mid -->
		
		<!-- footer -->
		<@FOOTER@>
		<!-- /footer -->
		
		<div class="clear"></div>
	</div>
	<!-- wrapper -->
</body>
<@BOTTOMBAR@>
</html>