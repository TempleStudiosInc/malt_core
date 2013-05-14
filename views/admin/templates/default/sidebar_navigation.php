<div class="well sidebar-nav">
    <ul class="nav nav-list">
        <li class="nav-header"><?php echo $requested_controller ?></li>
        <?php
            foreach ($sidebar_navigation as $method => $title)
            {
                echo '<li';
                if ($method == $requested_action)
                {
                    echo ' class="active"';
                }
                echo '>';
                echo HTML::anchor('/admin_'.strtolower($requested_controller).'/'.$method, $title);
                echo '</li>';
            }
        ?>
    </ul>
</div><!--/.well -->