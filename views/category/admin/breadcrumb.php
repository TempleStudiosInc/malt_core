<?php
	echo HTML::anchor('/admin_category', 'Categories');
	foreach ($items as $url => $item)
	{
		echo '<i class="icon icon-chevron-right" style="color:#666;"></i>';
		echo HTML::anchor($url, $item, array('class' => 'current'));
	}
?>