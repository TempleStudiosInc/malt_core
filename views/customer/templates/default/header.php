<?php echo HTML::anchor('/', HTML::image('_media/core/customer/img/logo.png'), array('class' => 'logo')) ?>
<div class="navbar" id="header_navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar_container">
                <div class="nav-collapse collapse" style="height: 0px; ">
                    <ul class="nav">
                        <?php
                            /* Example Item
                            $li_class = '';
                            $link_url = '/';
                            if ($requested_uri == $link_url)
                            {
                                $li_class = 'active';
                            }
                            echo '<li class="'.$li_class.'">';
                            echo HTML::anchor($link_url, HTML::image('media/customer/img/home_icon.png'));
                            echo '</li>'; */
                        ?>
                        <!-- END HOME NAV -->
                        
                    	<?php
				            if ($logged_in)
				            {
				            	echo '<li>'.HTML::anchor('/profile/edit', $user->username).'</li>';
				                echo '<li>'.HTML::anchor('/logout', 'Log out').'</li>';
				            }
				            else
				            {
				                echo '<li>'.HTML::anchor('/login', 'Login/Register').'</li>';
				            }
    					?>
                    </ul>                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END NAVBAR -->