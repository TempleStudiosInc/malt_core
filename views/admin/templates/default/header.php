<div id="header">
	<h1><?php echo HTML::anchor('/', $site_name) ?></h1>		
</div>
<div id="user-nav" class="navbar navbar-inverse">
    <ul class="nav btn-group">
    	<?php
			if ($user AND $user->id > 0)
			{
				echo '<li class="btn btn-inverse">';
				echo HTML::anchor('/admin_user/edit/'.$user->id, '<i class="icon icon-user"></i> <span class="text">'.$user->username.'</span>');
				echo '</li>';
				echo '<li class="btn btn-inverse">';
				echo HTML::anchor('/logout', '<i class="icon icon-share-alt"></i> <span class="text">Logout</span>');
				echo '</li>';
			}
		?>
    </ul>
</div>