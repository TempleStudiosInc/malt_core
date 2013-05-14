<div class="well">
	<div class="form medium_form">
		<?php echo Form::open('/admin_category/save', array('class' => 'category_form')) ?>
		<div class="form_field">
			<?php
				$no_parent = array(0 => 'None');
				$select_options = Arr::merge($no_parent, $parent_ids);
				echo Form::hidden('form[id]', $category->id);
				echo Form::label('form[parent]', 'Parent Category');
				echo Form::select('form[parent]', $select_options, $category->parent_id);
			?>
		</div>
		<div class="form_field">
			<?php
				echo Form::label('form[name]', 'Category Name');
				echo Form::input('form[name]', $category->name);
			?>
		</div>
		<div class="form_field">
			<?php
				echo Form::label('form[description]', 'Description');
				echo Form::textarea('form[description]', $category->description, array('class' => 'ckeditor'));
			?>
		</div>
		<div class="buttons">
            <?php echo Form::button(NULL, 'Save', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
            or
            <?php echo HTML::anchor('/admin_category/', 'Cancel', array('class' => '')) ?>
        </div>
		<?php echo Form::close() ?>
	</div>
</div>