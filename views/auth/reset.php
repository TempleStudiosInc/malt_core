<?php
	echo HTML::script('_media/core/common/js/libs/jquery.validate.min.js');
?>
<div class="row">
	<div class="span6">
		<h2>Reset Password</h2>
		<?php
		    echo Form::open('/auth/process_reset', array('class' => 'well form-horizontal', 'id' => 'reset_form'));
			echo Form::hidden('reset[reset_code]', $reset_code);
			
			echo '<div class="control-group">';
			echo Form::label('reset[new_password]', 'Email', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('reset[email]', $reset_user->email, array('class' => 'span3', 'readonly' => 'readonly'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('reset[new_password]', 'New Password', array('class' => 'control-label'));
			echo '<div class="controls">';
	        echo Form::password('reset[new_password]', '', array('class' => 'span3', 'id' => 'new_password'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('reset[new_password_confirm]', 'Password Repeat', array('class' => 'control-label'));
			echo '<div class="controls">';
	        echo Form::password('reset[new_password_confirm]', '', array('class' => 'span3'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('', '');
			echo '<div class="controls">';
			echo Form::submit(NULL, 'Update Password', array('class' => 'btn btn-primary'));
			echo '</div>';
			echo '</div>';
			
			echo Form::close();
		?>
	</div>