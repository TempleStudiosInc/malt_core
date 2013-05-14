<?php
	echo HTML::script('_media/core/common/js/libs/jquery.validate.min.js');
?>
<div class="span6">
	<div class="well">
	<?php
	    echo Form::open('/'.$application.'_auth/process_login', array('class' => 'form-horizontal', 'id' => 'login_form'));
		echo '<h2>Login</h2>';
		echo '<div class="control-group">';
		echo Form::label('login[username]', 'Username/Email', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo '<div class="input-prepend">';
		echo '<span class="add-on"><i class="icon-user"></i></span>';
        echo Form::input('login[username]', '', array('class' => 'span3'));
		echo '</div>';
		echo '</div>';
		echo '</div>';
		
		echo '<div class="control-group">';
		echo Form::label('login[password]', 'Password', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo '<div class="input-prepend">';
		echo '<span class="add-on"><i class="icon-lock"></i></span>';
        echo Form::password('login[password]', '', array('class' => 'span3'));
		echo '</div>';
		echo '</div>';
		echo '</div>';
		
		echo '<div class="control-group">';
		echo Form::label('', '');
		echo '<div class="controls">';
		echo Form::submit(NULL, 'Login', array('class' => 'btn btn-primary'));
		echo '<br/><br/>';
		echo HTML::anchor('/auth/forgot_password', 'Forgot Password?');
		echo '</div>';
		echo '</div>';		
		echo Form::close();
		
		echo '<h2>Social Login</h2>';
		echo '<div id="social_login">';
		echo '<div class="btn-group">';
		echo Form::button(NULL, HTML::anchor('/auth/login_facebook','<i class="icon-facebook-sign"></i>&nbsp;Login'), array('class' => 'btn btn-facebook'));
		echo Form::button(NULL, HTML::anchor('/auth/login_twitter','<i class="icon-twitter-sign"></i>&nbsp;Login'), array('class' => 'btn btn-twitter'));
		echo Form::button(NULL, HTML::anchor('/auth/login_google','<i class="icon-google-plus-sign"></i>&nbsp;Login'), array('class' => 'btn btn-google'));
		echo '</div>';
		echo '</div>';
	?>
	</div>
	
</div>
<div class="span6">
	<?php
	    echo Form::open('/'.$application.'_auth/process_register', array('class' => 'well form-horizontal', 'id' => 'register_form'));
		echo '<h2>Register</h2>';
		echo '<div class="control-group">';
		echo Form::label('register[email]', 'Email', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo Form::input('register[email]', '', array('class' => 'span3'));
		echo '</div>';
		echo '</div>';
		
		echo '<div class="control-group">';
		echo Form::label('register[username]', 'Username', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo Form::input('register[username]', '', array('class' => 'span3'));
		echo '</div>';
		echo '</div>';
		
		echo '<div class="control-group">';
		echo Form::label('register[password]', 'Password', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo Form::password('register[password]', '', array('class' => 'span3', 'id' => 'password'));
		echo '</div>';
		echo '</div>';
		
		echo '<div class="control-group">';
		echo Form::label('register[password_confirm]', 'Password Repeat', array('class' => 'control-label'));
		echo '<div class="controls">';
		echo Form::password('register[password_confirm]', '', array('class' => 'span3'));
		echo '</div>';
		echo '</div>';
		
		echo '<div class="control-group">';
		echo Form::label('', '');
		echo '<div class="controls">';
		echo Form::submit(NULL, 'Register', array('class' => 'btn btn-primary'));
		echo '</div>';
		echo '</div>';
		
		echo Form::close();
	?>
</div>

<script>
	$(function() {
		$("input[name|='login[username]']").focus();
		
		$("#register_form").validate({
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
		    	'register[username]' : {
		    		required: true,
		    		remote: '/customer_auth/check_username'
		    	},
		        'register[email]' : {
		            required: true,
		            email: true,
		            remote: '/customer_auth/check_email'
		        },
		        'register[password]' : {
		    		required: true,
		    		minlength: 8
		    	},
		    	'register[password_confirm]' : {
		    		required: true,
		    		equalTo: '#password'
		    	}
		    },
		    messages: {
		    	'register[username]' : {
		    		remote: 'This username is already registered.'
		    	},
		        'register[email]' : {
		            remote: 'This email is already registered.'
		        },
		        'register[password_confirm]' : {
		    		equalTo: 'Passwords do not match.'
		    	}
		    }
		});
	})
</script>