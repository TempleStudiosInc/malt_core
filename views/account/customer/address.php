<div class="row">
	<div class="span8">
		<?php
			echo Form::open('/account/save_address', array('class' => 'form-horizontal', 'id' => 'account_form'));
			
			echo '<h3>Billing Address</h3>';
		    echo '<div class="well">';
			
			echo '<div class="control-group">';
			echo Form::label('address[billing][address]', 'Address', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[billing][address]', $billing_address->address_1, array('placeholder' => 'Address', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[billing][address_2]', 'Address (cont.)', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[billing][address_2]', $billing_address->address_2, array('placeholder' => 'Address (cont.)', 'class' => 'input-block-level'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[billing][city]', 'City', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[billing][city]', $billing_address->city, array('placeholder' => 'City', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[billing][state]', 'State', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[billing][state]', $billing_address->state, array('placeholder' => 'State', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[billing][zip]', 'Zip', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[billing][zip]', $billing_address->zip, array('placeholder' => 'Zip', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[billing][country]', 'Country', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::select('address[billing][country]', $regions, $billing_address->country, array('class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '</div>';
			echo '<h3>Shipping Address</h3>';
		    echo '<div class="well">';
			
			echo '<div class="control-group">';
			echo Form::label('address[shipping][address]', 'Address', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[shipping][address]', $shipping_address->address_1, array('placeholder' => 'Address', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[shipping][address_2]', 'Address (cont.)', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[shipping][address_2]', $shipping_address->address_2, array('placeholder' => 'Address (cont.)', 'class' => 'input-block-level'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[shipping][city]', 'City', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[shipping][city]', $shipping_address->city, array('placeholder' => 'City', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[shipping][state]', 'State', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[shipping][state]', $shipping_address->state, array('placeholder' => 'State', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[shipping][zip]', 'Zip', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::input('address[shipping][zip]', $shipping_address->zip, array('placeholder' => 'Zip', 'class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('address[shipping][country]', 'Country', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::select('address[shipping][country]', $regions, $shipping_address->country, array('class' => 'input-block-level required'));
			echo '</div>';
			echo '</div>';
			
			echo '</div>';
			
			echo '<div class="control-group">';
			echo Form::label('', '', array('class' => 'control-label'));
			echo '<div class="controls">';
			echo Form::button(null, 'Save', array('class' => 'btn btn-primary'));
			echo '</div>';
			echo '</div>';
			
			echo Form::close();
		?>
	</div>
</div>