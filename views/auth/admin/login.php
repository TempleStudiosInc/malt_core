<script>
    $(function() {
        $("input[name|='login[username]']").focus();
    });
</script>
<?php
    echo Form::open('/'.$application.'_auth/process_login', array('class' => 'well'));
?>
<div class="form_field">
    <?php
        echo Form::label('login[username]', 'Username/Email');
		echo '<div class="input-prepend">';
		echo '<span class="add-on"><i class="icon-user"></i></span>';
        echo Form::input('login[username]', '', array('class' => 'span3'));
		echo '</div>';
    ?>
</div>
<div class="form_field">
    <?php 
        echo Form::label('login[password]', 'Password');
		echo '<div class="input-prepend">';
		echo '<span class="add-on"><i class="icon-lock"></i></span>';
        echo Form::password('login[password]', '', array('class' => 'span3'));
		echo '</div>';
    ?>
</div>
<?php
    echo Form::submit(NULL, 'Login', array('class' => 'btn btn-primary'));
    
    echo Form::close();
?>