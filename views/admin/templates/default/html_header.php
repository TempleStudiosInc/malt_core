<head>
	<title><?php echo $title ?></title>
	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
	<?php
    	echo HTML::style('_media/core/common/css/bootstrap.min.css');
		echo HTML::style('_media/core/common/css/bootstrap-responsive.min.css');
		echo HTML::style('_media/core/common/css/fullcalendar.css');
		
		echo HTML::style('_media/core/common/css/font-awesome.min.css');
    	echo HTML::style('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css');
		echo HTML::style('http://fonts.googleapis.com/css?family=Ubuntu:400,500,700');
		
		echo HTML::style('_media/core/admin/css/unicorn.main.css');
		echo HTML::style('_media/core/admin/css/unicorn.grey.css', array('class' => 'skin-color'));
		
		echo HTML::style('_media/core/common/css/bootstrap-image-gallery.min.css');
	    echo HTML::style('_media/core/common/jquery_file_uploader/css/jquery.fileupload-ui.css');
	    echo HTML::style('_media/core/admin/css/asset.css');
		echo HTML::style('_media/core/common/css/bootstrap-tagmanager.css');
		echo HTML::style('_media/core/common/css/multi-select.css');
		echo HTML::style('_media/core/common/css/select2.css');
		echo HTML::style('_media/core/common/css/bootstrapSwitch.css');
		echo HTML::style('_media/core/common/css/daterangepicker.css');
		echo HTML::style('_media/core/common/css/bootstrap-datetimepicker.min.css');
		echo HTML::style('_media/core/common/css/bootstrap-datetimepicker.min.css');
		
		echo HTML::style('_media/core/admin/css/style.css');
		
		echo HTML::script('_media/core/common/js/libs/jquery-1.8.3.min.js');
	?>
	<!-- <link rel="stylesheet" href="css/unicorn.grey.css" class="skin-color" /> -->
</head>

<?php
	echo HTML::link('_media/core/common/ico/favicon.ico?v2', array('rel' => 'shortcut icon'));
	echo HTML::link('_media/core/common/ico/apple-touch-icon-114-precomposed.png?v2', array('rel' => 'apple-touch-icon-precomposed', 'sizes' => '114x114'));
	echo HTML::link('_media/core/common/ico/apple-touch-icon-72-precomposed.png?v2', array('rel' => 'apple-touch-icon-precomposed', 'sizes' => '72x72'));
	echo HTML::link('_media/core/common/ico/apple-touch-icon-57-precomposed.png?v2', array('rel' => 'apple-touch-icon-precomposed'));
?>