<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<title><?php echo $title ?></title>
<meta name="description" content=""/>
<meta name="author" content=""/>
<meta name="viewport" content="width=device-width"/>
<?php
	if ($header_vars != '')
	{
		echo $header_vars;
	}
?>
<?php
    echo HTML::style('_media/core/common/css/jquery-ui-1.8.18.custom.css');
?>

<?php
	require Kohana::find_file('vendor', 'lessphp/lessc.inc');
	$less = new lessc;
	
	// $less->checkedCompile('_media/core/customer/less/styles.less', '_media/website/customer/css/common_styles.css');
	// $less->checkedCompile('_media/website/customer/less/styles.less', '_media/website/customer/css/website_styles.css');
	$less->compileFile('_media/core/customer/less/styles.less', '_media/website/customer/css/common_styles.css');
	$less->compileFile('_media/website/customer/less/styles.less', '_media/website/customer/css/website_styles.css');
	echo HTML::style('_media/website/customer/css/common_styles.css');
	echo HTML::style('_media/website/customer/css/website_styles.css');
?>

<!--[if lt IE 9]>
    <?php echo HTML::style('_media/core/customer/css/skin_ie.css'); ?>
<![endif]-->

<?php
    echo HTML::script('_media/core/common/js/libs/jquery-1.7.2.min.js');
    echo HTML::script('_media/core/common/js/bootstrap.min.js');
    echo HTML::script('_media/core/common/js/libs/modernizr-2.5.3.min.js');
?>

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="/_media/core/common/ico/favicon.ico"/>
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/_media/core/common/ico/apple-touch-icon-114-precomposed.png"/>
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/_media/core/common/ico/apple-touch-icon-72-precomposed.png"/>
<link rel="apple-touch-icon-precomposed" href="/_media/core/common/ico/apple-touch-icon-57-precomposed.png"/>