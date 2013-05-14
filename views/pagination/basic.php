<div class="pagination">
    <ul>
    <?php if ($first_page !== FALSE): ?>
        <li><a href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><<</a></li>
    <?php else: ?>
        <li class="disabled"><a href="#"><<</a></li>
    <?php endif ?>

    <?php if ($previous_page !== FALSE): ?>
        <li><a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"><</a></li>
    <?php else: ?>
        <li class="disabled"><a href="#"><</a></li>
    <?php endif ?>

    <?php
        $front = 3;
        $middle = 3;
        $end = 3;
        
        if ($total_pages <= ($front+$middle+$end))
        {
            for ($i = 1; $i <= $total_pages; $i++)
            {
                $li_class = '';
                $link_url = HTML::chars($page->url($i));
				$link_url = str_replace('&amp;', '&', $link_url);
                if ($i == $current_page)
                {
                    $li_class = 'active';
                    $link_url = '#';
                }
                echo '<li class="'.$li_class.' hidden-phone">';
                echo HTML::anchor($link_url, $i);
                echo '</li>';
            }
        }
        else
        {
            for ($i = 1; $i <= $front; $i++)
            {
                $li_class = '';
                $link_url = HTML::chars($page->url($i));
				$link_url = str_replace('&amp;', '&', $link_url);
                if ($i == $current_page)
                {
                    $li_class = 'active';
                    $link_url = '#';
                }
                echo '<li class="'.$li_class.' hidden-phone">';
                echo HTML::anchor($link_url, $i);
                echo '</li>';
            }
            if ($current_page > $front AND $current_page < $total_pages-$end)
            {
                echo '<li class="disabled">';
                echo HTML::anchor('#', '...');
                echo '</li>';
                
                echo '<li>';
                echo HTML::anchor(HTML::chars($page->url($current_page-1)), $current_page-1);
                echo '</li>';
                
                echo '<li class="active">';
                echo HTML::anchor('#', $current_page);
                echo '</li>';
                
                echo '<li>';
                echo HTML::anchor(HTML::chars($page->url($current_page+1)), $current_page+1);
                echo '</li>';
                
                echo '<li class="disabled">';
                echo HTML::anchor('#', '...');
                echo '</li>';
            }
            else
            {
                echo '<li class="disabled">';
                echo HTML::anchor('#', '...');
                echo '</li>';
            }
            for ($i = $total_pages-($end-1); $i <= $total_pages; $i++)
            {
                $li_class = '';
                $link_url = HTML::chars($page->url($i));
				$link_url = str_replace('&amp;', '&', $link_url);
                if ($i == $current_page)
                {
                    $li_class = 'active';
                    $link_url = '#';
                }   
                echo '<li class="'.$li_class.' hidden-phone">';
                echo HTML::anchor($link_url, $i);
                echo '</li>';
            }
        }
    ?>
    
    <?php if ($next_page !== FALSE): ?>
        <li><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next">></a></li>
    <?php else: ?>
        <li class="disabled"><a href="#">></a></li>
    <?php endif ?>

    <?php if ($last_page !== FALSE): ?>
        <li><a href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="last">>></a></li>
    <?php else: ?>
        <li class="disabled"><a href="#">>></></a></li>
    <?php endif ?>
    </ul>
</div><!-- .pagination -->