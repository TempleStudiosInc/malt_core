<!DOCTYPE html>
<html lang="en">
	<head>
		<?php echo $html_header ?>
	</head>
	<body>
		<?php
			echo $header;
			echo $sidebar;
		?>
		<div id="content">
			<div id="content-header">
				<h1><?php echo isset($content_title)?$content_title:''; ?></h1>
				<?php
					if (isset($content_header_navigation))
					{
						echo '<div class="btn-group">';
						echo $content_header_navigation;
						echo '</div>';
					}
				?>
			</div>
			<?php
				if (isset($breadcrumb))
				{
					echo '<div id="breadcrumb">';
					echo HTML::anchor('/', '<i class="icon-home"></i> Home</a>');
					echo '<i class="icon icon-chevron-right" style="color:#666;"></i>';
					echo $breadcrumb;
					echo '</div>';
				}
			?>
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span12 center">
						<?php echo Notice::render(); ?>
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12 center">	
					<?php
						$show_sidebar = false;
						if (isset($sidebar_navigation) AND $sidebar_navigation)
						{
							if (strstr($sidebar_navigation->_file, 'admin/templates/default/sidebar_navigation') !== false)
							{
								if (count($sidebar_navigation->sidebar_navigation) > 0)
								{
									$show_sidebar = true;
								}
							}
							else
							{
								$show_sidebar = true;
							}
						}
						
						if ($show_sidebar)
						{	
							echo '<div class="span3">';
							echo $sidebar_navigation;
							echo '</div>';
							echo '<div class="span9 printable">';
						}
						else
						{
							echo '<div class="span12 printable">';
						}
						echo $body;
						echo '</div>';
					?>
					</div>
				</div>
				<div class="row-fluid">
					<?php echo $footer ?>
				</div>
			</div>
			<div class="container-fluid">
				
			</div>
		</div>
		
		<?php
			echo HTML::script('_media/core/common/js/excanvas.min.js');
			echo HTML::script('_media/core/common/js/libs/jquery-ui-1.8.21.custom.min.js');
			echo HTML::script('_media/core/common/js/bootstrap.min.js');
			echo HTML::script('_media/core/common/js/jquery.flot.min.js');
        	echo HTML::script('_media/core/common/js/jquery.flot.resize.min.js');
	        echo HTML::script('_media/core/common/js/jquery.peity.min.js');
	        // echo HTML::script('_media/core/common/js/fullcalendar.min.js');
	        echo HTML::script('_media/core/admin/js/unicorn.js');
	        // echo HTML::script('_media/core/admin/js/unicorn.dashboard.js');
			
            echo HTML::script('_media/core/common/js/libs/jquery.validate.min.js');
            echo HTML::script('_media/core/admin/js/script.js');
			echo HTML::script('_media/website/admin/js/script.js');
            echo HTML::script('_media/core/admin/js/libs/tablesorter.js');
		    echo HTML::script('/_media/core/admin/js/libs/ckeditor/ckeditor.js');
			echo HTML::script('/_media/core/common/js/bootstrapSwitch.js');
			echo HTML::script('/_media/core/common/js/bootstrap-datetimepicker.js');
			echo HTML::script('/_media/core/common/js/bootstrap-tagmanager.js');
			echo HTML::script('/_media/core/common/js/jquery.multi-select.js');
			echo HTML::script('/_media/core/common/js/select2.min.js');
			echo HTML::script('/_media/core/common/js/jquery.currency.js');
			echo HTML::script('/_media/core/common/js/date.js');
			echo HTML::script('/_media/core/common/js/daterangepicker.js');
			
			echo HTML::script('_media/core/common/jquery_file_uploader/js/content_main.js');
		    // echo HTML::script('_media/core/common/jquery_file_uploader/js/vendor/jquery.ui.widget.js');
		    echo HTML::script('_media/core/common/js/load-image.min.js');
		    echo HTML::script('_media/core/common/js/canvas-to-blob.min.js');
		    echo HTML::script('_media/core/common/jquery_file_uploader/js/locale.js');
			
            echo HTML::script('_media/core/common/jquery_file_uploader/js/jquery.iframe-transport.js');
            echo HTML::script('_media/core/common/jquery_file_uploader/js/jquery.fileupload.js');
            echo HTML::script('_media/core/common/jquery_file_uploader/js/jquery.fileupload-fp.js');
            echo HTML::script('_media/core/common/jquery_file_uploader/js/jquery.fileupload-ui.js');
		?>
	</body>
</html>