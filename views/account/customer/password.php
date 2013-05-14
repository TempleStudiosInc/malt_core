<div class="row">
	<div class="span8">
		<h3>Change Password</h3>
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

<script>
	$(function() {
		$("#account_form").validate({
			errorClass:'error',
		    validClass:'success',
		    highlight: function (element, errorClass, validClass) { 
		        $(element).parents("div.control-group").addClass(errorClass).removeClass(validClass); 
		    }, 
		    unhighlight: function (element, errorClass, validClass) { 
		        $(element).parents("div.control-group").removeClass(errorClass).addClass(validClass); 
		    },
		    showErrors: function (errorMap, errorList) {
		        // destroy tooltips on valid elements                              
		        $(".success > .controls > input").tooltip("destroy");
		        
		        // add/update tooltips 
		        for (var i = 0; i < errorList.length; i++) {
		            var error = errorList[i];
		            
		            $('input[name="'+error.element.name+'"]').attr("data-original-title", '<h5>'+error.message+'</h5>')
		            $('input[name="'+error.element.name+'"]').tooltip({
		            	trigger: "focus",
		            	html: '<h5>'+error.message+'</h5>'
	            	});
		        }
		        
		        this.defaultShowErrors();
		    },
		    errorPlacement: function(error, element){
			    
			},
		    rules: {
		        'account[password]' : {
		    		required: true,
		    		remote: '/account/check_password'
		    	},
		    	'account[new_password]' : {
		    		required: true,
		    		minlength: 8
		    	},
		    	'account[new_password_confirm]' : {
		    		required: true,
		    		equalTo: '#new_password'
		    	}
		    }
		});
	})
</script>