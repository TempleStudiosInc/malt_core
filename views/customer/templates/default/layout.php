<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
	<head>
		<?php echo $html_header ?>
	</head>

	<body>
		<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->
  		<header>
  			<?php echo $header ?>
		</header>
		
		<div id="body" class="container">
			<?php
                echo Notice::render();
                $body->protocol = $protocol;
                echo $body;
			?>
		</div>
		
		<footer>
			<?php echo $footer ?>
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
