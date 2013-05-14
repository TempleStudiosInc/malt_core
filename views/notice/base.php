<div id="notification_container">
<?php 
	if (count($notifications) > 0)
	{
		foreach($notifications as $type => $notification)
		{
			if ( ! empty($notification))
			{
				foreach ($notification as $notice)
				{
?>
	<div class="alert alert-block alert-<?php echo $type ?>">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4><?php echo __(UTF8::ucfirst($type)) ?></h4>
		<?php 
			if ($notice['message'] !== NULL)
			{
				echo $notice['message'];
			}
			if ( ! empty($notice['items']))
			{
				echo '<ul>';
				foreach($notice['items'] as $item)
				{
					if ( ! is_array($item))
					{
						echo '<li>'.__($item).'</li>';
					}
					else
					{
						foreach ($item as $subitem)
						{
							echo '<li>'.__($subitem).'</li>';
						}
					}
				}
				echo '</ul>';
			}
		?>
	</div>
<?php
				}
			}
		}
	}
?>
</div>