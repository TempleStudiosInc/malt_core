<div class="well">
	<div class="form medium_form">
		<?php
			echo Form::open('/admin_tag/', array('method' => 'get'));
		?>
		<div class="form_field">
			<?php 
				echo Form::label('form[name]', 'Name');
				echo Form::input('form[name]', $form['name']);
			?>
		</div>
		<div class="buttons">
			<?php echo Form::button(NULL, 'Search', array('type' => 'submit', 'class' => 'btn btn-primary btn-small')); ?>
		</div>
		<?php
            echo Form::close();
        ?>
	</div>
	<div><?php echo $pagination; ?></div>
    <div class="navbar">
		<div class="navbar-inner">
			<ul class="nav">
	    		<li style="margin-right: 15px;">
					<div><?php echo $view_all_button; ?></div>
				</li>
	    	</ul>
    	</div>
    </div>
	<table class="table table-striped" id="assets_table">
		<thead>
			<tr>
				<th><?php echo Format::create_sort_link('Name', 'name', $query_array, '/admin_tag/') ?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($tags as $tag)
				{
					echo '<tr class="table_row '.Text::alternate('odd', 'even').'">';
					echo '<td>'.$tag->name.'</td>';
					echo '<td style="text-align:right;" class="btn-group">';
					echo HTML::anchor('/admin_tag/edit/'.$tag->id, 'Edit', array('alt' => 'Edit', 'class' => 'btn btn-small'));
					echo HTML::anchor('/admin_tag/delete/'.$tag->id.'?'.http_build_query($query_array), 'Delete', array('alt' => 'Delete', 'class' => 'delete btn btn-small btn-danger'));
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