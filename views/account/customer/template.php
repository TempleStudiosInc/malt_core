<?php
	echo HTML::script('_media/core/common/js/libs/jquery.validate.min.js');
?>
<div class="row">
	<div class="span4 page_header_container">
		<div class="page_header">
			<div class="page_header_container">
				<div class="page_header">
					<h1>Account</h1>
				</div>
			</div>
		</div>
	</div>
	<div class="span12 page_container">
		<div class="row page">
			<div class="span4 page_sidebar_container">
				<div class="page_sidebar">
					<ul class="nav nav-list">
		            	<li>
		            		<ul class="nav nav-list">
			            		<?php
			            			$sidebar = Kohana::$config->load('navigation.sidebar.account');
									foreach ($sidebar as $item)
									{
										$class = '';
										if (Request::initial()->detect_uri() == $item['url'])
										{
											$class = 'active';
										}
										echo '<li class="'.$class.'">'.HTML::anchor($item['url'], $item['title']).'</li>';
									}
								?>
		            		</ul>
		            	</li>
		        	</ul>
				</div>
			</div>
			<div class="span8 page_body_container">
				<div class="page_body">
					<?php echo $page ?>
				</div>
			</div>
		</div>
	</div>
</div>