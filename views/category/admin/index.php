<h3>
	<?php
		echo HTML::anchor('admin_category/add', 'Add Category', array('class' => 'pull-right btn btn-success'));
	?>
</h3>
<div class="well">
	<div class="form medium_form">
		<?php
			echo Form::open('/admin_category/', array('method' => 'get'));
		?>
		<div class="form_field">
			<?php 
				echo Form::label('form[name]', 'Name');
				echo Form::input('form[name]', $form['name']);
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[parent_id]', 'Parent ID');
				echo Form::input('form[parent_id]', $form['parent_id']);
			?>
		</div>
		<div class="form_field">
			<?php 
				echo Form::label('form[level]', 'Level');
				echo Form::input('form[level]', $form['level']);
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
				<th><?php echo Format::create_sort_link('Name', 'name', $query_array, '/admin_category/') ?></th>
				<th><?php echo Format::create_sort_link('Level', 'level', $query_array, '/admin_category/') ?></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($categories as $category)
				{
					echo '<tr class="table_row '.Text::alternate('odd', 'even').'">';
					echo '<td>';
					for ($x = 1; $x < $category->level; $x++)
					{
						echo '&nbsp;&nbsp;&nbsp;&nbsp;- ';
					}
					echo $category->name;
					echo '</td>';
					echo '<td>'.$category->level.'</td>';
					echo '<td>';
					$children_count = count($category->children());
					if ($children_count > 0)
					{
						$query_array = array();
						$query_array['form']['parent_id'] = $category->id;
						echo HTML::anchor('/admin_category/?'.http_build_query($query_array), '<i class="icon-chevron-down"></i> View Children ('.$children_count.')', array('alt' => 'View Children', 'class' => 'btn btn-small'));
					}
					if ($category->parent->id > 0)
					{
						$query_array = array();
						$query_array['form']['level'] = $category->parent->level;
						echo HTML::anchor('/admin_category/?'.http_build_query($query_array), '<i class="icon-chevron-up"></i> View Parent Level', array('alt' => 'View Children', 'class' => 'btn btn-small'));
					}
					echo '</td>';
					echo '<td style="text-align:right;" class="btn-group">';
					echo HTML::anchor('/admin_category/edit/'.$category->id, 'Edit', array('alt' => 'Edit', 'class' => 'btn btn-small'));
					echo HTML::anchor('/admin_category/delete/'.$category->id.'?'.http_build_query($query_array), 'Delete', array('alt' => 'Delete', 'class' => 'delete btn btn-small btn-danger'));
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