<?php
	echo HTML::script('_media/core/common/js/libs/jquery.validate.min.js');
?>
<style>
	.error {
		color:red;
	}
</style>
<script>
$(function(){
	$('#forgot_form').validate({
		rules:{
			'forgot[username]':{
				required:true,
				remote:'/auth/check_email_exists'
			}
		},
		messages: {
			'forgot[username]':{
				required:'Username or email required',
				remote:'That email address is not associated with any account on ToG'
			}	
		}
	});
})
</script>
<div class="row">
	<div class="span6">
		<h2>Forgot Password</h2>
		<?php
		    echo Form::open('/auth/forgot_password', array('class' => 'well form-horizontal', 'id' => 'forgot_form'));
			
			echo '<div class="control-group">';
			echo Form::label('forgot[username]', 'Email', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo '<div class="input-prepend">';
			echo '<span class="add-on"><i class="icon-user"></i></span>';
	        echo Form::input('forgot[username]', '', array('class' => 'span3'));
			echo '</div>';
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('', '');
			echo '<div class="controls">';
			echo Form::submit(NULL, 'Submit Reset', array('class' => 'btn btn-primary'));
			echo '</div>';
			echo '</div>';
			
			echo Form::close();
		?>
	</div>
</div>