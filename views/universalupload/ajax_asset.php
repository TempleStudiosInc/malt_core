<tr class="asset" id="asset_<?php echo $asset->id ?>" asset_id="<?php echo $asset->id ?>">
	<td>
		<div class="asset_image pull-left">
		<?php
            $image = $asset->files->where('type', '=', 'image_small_square')->find()->url;
			if ($image != '' AND $image != NULL)
			{
				echo HTML::image($image, array('class' => 'thumbnail'));
			}
		?>
        </div>
	</td>
	<td style="width:130px;">
		<?php
			
			if (isset($action))
			{
				if ($action == 'add')
				{
					$button_text = '<i class="icon-plus icon-white"></i> Add '.ucfirst($asset->type);
					$button_attributes = array('class' => 'content_add_'.$type.' btn btn-small btn-primary');
					echo Form::button(NULL, $button_text, $button_attributes);
				}
			}
			
		?>
	</td>
</tr>