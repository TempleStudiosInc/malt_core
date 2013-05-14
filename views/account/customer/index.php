<div class="row">
	<div class="span8">
		<div class="well">
			<h3>Edit Account</h3>
			<?php
			    echo Form::open('/account/save', array('class' => 'form-horizontal', 'id' => 'account_form'));
				
				echo '<div class="control-group">';
				echo Form::label('account[email]', 'Email Address', array('class' => 'control-label'));
				echo '<div class="controls">';
		        echo Form::input('account[email]', $user->email, array('class' => 'span3'));
				echo '</div>';
				echo '</div>';
				
				echo '<div class="control-group">';
				echo Form::label('account[username]', 'Username', array('class' => 'control-label'));
				echo '<div class="controls">';
		        echo Form::input('account[username]', $user->username, array('class' => 'span3'));
				echo '</div>';
				echo '</div>';
				
				echo '<div class="control-group">';
				echo Form::label('account[first_name]', 'First Name', array('class' => 'control-label'));
				echo '<div class="controls">';
		        echo Form::input('account[first_name]', $user->first_name, array('class' => 'span3'));
				echo '</div>';
				echo '</div>';
				
				echo '<div class="control-group">';
				echo Form::label('account[last_name]', 'Last Name', array('class' => 'control-label'));
				echo '<div class="controls">';
		        echo Form::input('account[last_name]', $user->last_name, array('class' => 'span3'));
				echo '</div>';
				echo '</div>';
				
				echo '<div class="control-group">';
				echo Form::label('account[password]', 'Current Password', array('class' => 'control-label'));
				echo '<div class="controls">';
		        echo Form::password('account[password]', '', array('class' => 'span3'));
				echo '</div>';
				echo '</div>';
				
				echo '<div class="control-group">';
				echo Form::label('', '');
				echo '<div class="controls">';
				echo Form::button(NULL, '<i class="icon icon-save"></i> Save', array('class' => 'btn btn-primary'));
				echo '</div>';
				echo '</div>';
				
				echo Form::close();
				
				echo '<h3>Social Accounts</h3>';
				echo '<div id="account_social_links">';
				
				$facebook = ORM::factory('Oauthuser')->where('user_id', '=', $user->id)->where('oauth_type', '=', 'facebook')->find();
				if ($facebook->loaded())
				{
					echo Form::button(NULL, HTML::anchor('/account/disconnect_social/facebook','<i class="icon-facebook-sign"></i>&nbsp;Disconnect'), array('class' => 'btn btn-facebook'));
				}
				else 
				{
					echo Form::button(NULL, HTML::anchor('/account/connect_social/facebook','<i class="icon-facebook-sign"></i>&nbsp;Connect'), array('class' => 'btn btn-facebook'));
				}
				
				$twitter = ORM::factory('Oauthuser')->where('user_id', '=', $user->id)->where('oauth_type', '=', 'twitter')->find();
				if ($twitter->loaded())
				{
					echo Form::button(NULL, HTML::anchor('/account/disconnect_social/twitter','<i class="icon-twitter-sign"></i>&nbsp;Disconnect'), array('class' => 'btn btn-twitter'));
				}
				else 
				{
					echo Form::button(NULL, HTML::anchor('/account/connect_social/twitter','<i class="icon-twitter-sign"></i>&nbsp;Connect'), array('class' => 'btn btn-twitter'));
				}
				
				$google = ORM::factory('Oauthuser')->where('user_id', '=', $user->id)->where('oauth_type', '=', 'google')->find();
				if ($google->loaded())
				{
					echo Form::button(NULL, HTML::anchor('/account/disconnect_social/google','<i class="icon-google-plus-sign"></i>&nbsp;Disconnect'), array('class' => 'btn btn-google'));
				}
				else 
				{
					echo Form::button(NULL, HTML::anchor('/account/connect_social/google','<i class="icon-google-plus-sign"></i>&nbsp;Connect'), array('class' => 'btn btn-google'));
				}
				
				echo '</div>';
			?>
		</div>
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
		    	'account[username]' : {
		    		required: true,
		    		remote: '/account/check_username'
		    	},
		        'account[email]' : {
		            required: true,
		            email: true,
		            remote: '/account/check_email'
		        },
		        'account[password]' : {
		    		required: true,
		    		remote: '/account/check_password'
		    	}
		    },
		    messages: {
		    	'account[username]' : {
		    		remote: 'This username is already registered.'
		    	},
		        'account[email]' : {
		            remote: 'This email is already registered.'
		        }
		    }
		});
	})
</script>