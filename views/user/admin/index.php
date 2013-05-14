<div class="well">
	<div class="buttons">
		<?php echo HTML::anchor('/admin_user/add', 'Add '.Text::ucfirst($model_name), array('type' => 'submit', 'class' => 'btn btn-success')); ?>
	</div>
	<div class="form medium_form">
		<?php
			echo Form::open('/admin_'.$model_name.'/index/', array('method' => 'get'));
		?>
		<div class="form_field">
			<?php 
				echo Form::label('form[username]', 'Username');
				echo Form::input('form[username]', $form['username']);
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[email]', 'Email');
				echo Form::input('form[email]', $form['email']);
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[first_name]', 'First Name');
				echo Form::input('form[first_name]', $form['first_name']);
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[last_name]', 'Last Name');
				echo Form::input('form[last_name]', $form['last_name']);
			?>
		</div>
		<div class="buttons">
			<?php echo Form::button(NULL, '<i class="icon-search icon-white"></i>'.'Search', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
		</div>
		<?php
            echo Form::close();
            echo '<br/>';
            echo $view_all_button;
        ?>
    </div>
    </br>
    <div style="text-align:center;">
        <?php echo $pagination; ?>
    </div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th><?php echo Format::create_sort_link('ID', 'id', $query_array, 'admin_user') ?></th>
				<th><?php echo Format::create_sort_link('Username', 'username', $query_array, 'admin_user') ?></th>
				<th><?php echo Format::create_sort_link('Email', 'email', $query_array, 'admin_user') ?></th>
				<th><?php echo Format::create_sort_link('First Name', 'First_name', $query_array, 'admin_user') ?></th>
				<th><?php echo Format::create_sort_link('Last Name', 'last_name', $query_array, 'admin_user') ?></th>
				<?php
					foreach ($roles as $role)
					{
				?>
				<th><?php echo Text::ucfirst($role->name) ?></th>
				<?php
					}
				?>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$customer_role = ORM::factory('Role', array('name' => 'customer'));
				foreach ($users as $user)
				{
					echo '<tr class="table_row '.Text::alternate('odd', 'even').'">';
					echo '<td>'.$user->id.'</td>';
					echo '<td>'.$user->username.'</td>';
					echo '<td>'.$user->email.'</td>';
					echo '<td>'.$user->first_name.'</td>';
					echo '<td>'.$user->last_name.'</td>';
					foreach ($roles as $role)
					{
						echo '<td>';
						if ($user->has('roles', $role->id))
						{
							echo 'Yes';
						}
						else
						{
							echo 'No';
						}
						echo '</td>';
					}
					echo '<td style="text-align:right;" class="btn-group">';
					echo HTML::anchor('/admin_user/view/'.$user->id, 'View', array('alt' => 'View', 'class' => 'btn btn-small'));
					echo HTML::anchor('/admin_user/edit/'.$user->id, 'Edit', array('alt' => 'Edit', 'class' => 'btn btn-small'));
                    echo HTML::anchor('/admin_user/delete/'.$user->id, 'Delete', array('alt' => 'Delete', 'class' => 'delete btn btn-small btn-danger'));
                    
					echo '</td>';
					echo '</tr>';
				}
			?>
		</tbody>
	</table>
</div>

<div class="modal hide dialog" id="delete_dialog">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3>Confirmation Required</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to delete this?</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn modal_hide">No</a>
    <a href="#" class="btn btn-primary modal_delete_yes_button">Yes</a>
  </div>
</div>