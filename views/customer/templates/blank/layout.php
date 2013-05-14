<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		
		<title></title>
		<meta name="description" content=""/>
		<meta name="author" content=""/>
		<meta name="viewport" content="width=device-width"/>

		<!--[if lt IE 9]>
            <?php echo HTML::style('media/customer/css/skin_ie.css'); ?>
        <![endif]-->
		
		<?php
            echo HTML::script('media/common/js/libs/jquery-1.7.2.min.js');
        ?>
		
		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="/media/common/ico/favicon.ico"/>
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/media/common/ico/apple-touch-icon-114-precomposed.png"/>
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/media/common/ico/apple-touch-icon-72-precomposed.png"/>
		<link rel="apple-touch-icon-precomposed" href="/media/common/ico/apple-touch-icon-57-precomposed.png"/>
	</head>

	<body>
		<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  		<header>
  			
		</header>
		
		<div id="body" class="container">
			<?php
                echo Notice::render();
                echo $body;
			?>
		</div>
		
		<footer>
			
		</footer>
    	
    	<?php
            $analytics = Kohana::$config->load('website')->get('analytics');
            
            if ($analytics)
            {
        ?>
        <script>
            var _gaq=[['_setAccount','<?php echo $analytics ?>'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        <?php
            }
    	?>
	</body>
</html>
