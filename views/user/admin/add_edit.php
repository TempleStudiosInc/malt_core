<div class="content_body well">
	<div class="form medium_form">
		<?php
			echo Form::open('/admin_'.$model_name.'/save/'.$add_edit_user->id, array('method' => 'post'));
			echo Form::hidden('form[action]', $action);
		?>
		<div class="form_field">
			<?php 
				echo Form::label('form[user][email]', 'Email');
				echo Form::input('form[user][email]', $add_edit_user->email, array('class' => 'span8'));
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[user][username]', 'Username');
				echo Form::input('form[user][username]', $add_edit_user->username, array('class' => 'span8'));
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[user][first_name]', 'First Name');
				echo Form::input('form[user][first_name]', $add_edit_user->first_name, array('class' => 'span6'));
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[user][last_name]', 'Last Name');
				echo Form::input('form[user][last_name]', $add_edit_user->last_name, array('class' => 'span6'));
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[user][phone_number]', 'Phone Number');
				echo Form::input('form[user][phone_number]', $add_edit_user->phone_number, array('class' => 'span6'));
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[user][password]', 'Password');
				echo Form::password('form[user][password]', '', array('class' => 'span6'));
			?>
		</div>
		<?php
			foreach ($roles as $role)
			{
				$has_role = false;
				if ($add_edit_user->has('roles', $role->id))
				{
					$has_role = true;
				}
		?>
		<div class="form_field">
			<?php
                echo Form::checkbox('form[role]['.$role->id.']', 1, $has_role); 
				echo '&nbsp;&nbsp;<strong>'.Text::ucfirst($role->name).'</strong>';
                echo ' - '.$role->description;
			?>
		</div>
		<?php
			}
		?>
		<div class="buttons">
			<?php
                echo Form::button(NULL, 'Save', array('type' => 'submit', 'class' => 'btn btn-success'));
                echo '&nbsp;&nbsp;<small>or</small>&nbsp;&nbsp;';
                echo HTML::anchor('/admin_'.$model_name, 'cancel');
            ?>
		</div>
		<?php echo Form::close(); ?>
	</div>
</div>