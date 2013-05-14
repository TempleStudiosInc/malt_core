<div class="row">
	<div class="span8">
		<h3>Account Picture</h3>
		<?php
		    echo Form::open('/account/save_password', array('class' => 'well form-horizontal', 'id' => 'account_form'));
			
			echo '<div class="control-group">';
			echo Form::label('account[password]', 'Current Password', array('class' => 'control-label'));
			echo '<div class="controls">';
	        echo Form::password('account[password]', '', array('class' => 'span3'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('account[new_password]', 'New Password', array('class' => 'control-label'));
			echo '<div class="controls">';
	        echo Form::password('account[new_password]', '', array('class' => 'span3', 'id' => 'new_password'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('account[new_password_confirm]', 'Password Repeat', array('class' => 'control-label'));
			echo '<div class="controls">';
	        echo Form::password('account[new_password_confirm]', '', array('class' => 'span3'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('', '');
			echo '<div class="controls">';
			echo Form::button(NULL, '<i class="icon icon-save"></i> Save', array('class' => 'btn btn-primary'));
			echo '</div>';
			echo '</div>';
			
			echo Form::close();
		?>
	</div>
</div>
