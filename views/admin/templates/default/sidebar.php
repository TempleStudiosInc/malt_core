<div id="sidebar">	
	<ul>
	<?php
	    if ($user)
	    {
			foreach ($navigation as $navigation_item)
			{
			    if ($user->has('roles', ORM::factory('Role')->where('name', '=', $navigation_item['permission'])->find()))
	            {
	            	$submenu = Arr::get($navigation_item, 'submenu', false);
					
					if ( ! $submenu)
					{
						$li_class = '';
						if (strtolower($navigation_item['controller']) == strtolower($requested_controller))
						{
							$li_class = 'active';
						}
						$icon_class = Arr::get($navigation_item, 'icon', 'icon-th-large');
						echo '<li class="'.$li_class.'">';
						echo HTML::anchor(Arr::get($navigation_item, 'url'), '<i class="icon '.$icon_class.'"></i> <span>'.Arr::get($navigation_item, 'title').'</span>');
						echo '</li>';
					}
					else
					{
						ksort($submenu);
						$li_class = 'submenu';
						foreach ($submenu as $submenu_item)
						{
							if (strtolower($submenu_item['controller']) == strtolower($requested_controller))
							{
								$li_class.= ' open';
							}
						}
						
						echo '<li class="'.$li_class.'">';
						$icon_class = Arr::get($navigation_item, 'icon', 'icon-th-large');
						echo HTML::anchor($navigation_item['url'], '<i class="icon '.$icon_class.'"></i> <span>'.$navigation_item['title'].'</span> <span class="label"><i class="icon icon-chevron-down"></i></span>');
						echo '<ul>';
						foreach ($submenu as $submenu_item)
						{
							if ($user->has('roles', ORM::factory('Role')->where('name', '=', $submenu_item['permission'])->find()))
	            			{
								$li_class = '';
								if (strtolower($submenu_item['controller']) == strtolower($requested_controller))
								{
									$li_class = 'active';
								}
								$icon_class = Arr::get($submenu_item, 'icon', 'icon-th-large');
								echo '<li class="'.$li_class.'">';
								echo HTML::anchor(Arr::get($submenu_item, 'url'), '<i class="icon '.$icon_class.'"></i> <span>'.Arr::get($submenu_item, 'title').'</span>');
								echo '</li>';
							}
						}
						echo '</ul>';
						echo '</li>';
					}
	            }
	        }
		}
	?>
	</ul>
</div>		