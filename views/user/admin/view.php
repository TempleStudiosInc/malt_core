<div class="row-fluid">
	<div class="span6">
		<h4>Basic Information</h4>
		<dl class="dl-horizontal well">
			<dt>Email</dt>
			<dd><?php echo $add_edit_user->email ?></dd>
			
			<dt>Username</dt>
			<dd><?php echo $add_edit_user->username ?></dd>
			
			<dt>First Name</dt>
			<dd><?php echo $add_edit_user->first_name ?></dd>
			
			<dt>Last Name</dt>
			<dd><?php echo $add_edit_user->last_name ?></dd>
			
			<dt>Phone Number</dt>
			<dd><?php echo $add_edit_user->phone_number ?></dd>
		</dl>
		
		<?php
			$billing_address = $add_edit_user->addresses->where('type', '=', 'billing')->find();
			$shipping_address = $add_edit_user->addresses->where('type', '=', 'shipping')->find();
			
			if ($billing_address->loaded() OR $shipping_address->loaded())
			{
		?>
		<h4>Saved Addresses</h4>
		<dl class="dl-horizontal well">
		<?php
				if ($billing_address->loaded())
				{
		?>
			<h5>Billing Address</h5>
			<dt>Address</dt>
			<dd><?php echo $billing_address->address_1 ?>&nbsp;</dd>
			
			<dt>Address2</dt>
			<dd><?php echo $billing_address->address_2 ?>&nbsp;</dd>
			
			<dt>City</dt>
			<dd><?php echo $billing_address->city ?>&nbsp;</dd>
			
			<dt>State</dt>
			<dd><?php echo $billing_address->state ?>&nbsp;</dd>
			
			<dt>Zip</dt>
			<dd><?php echo $billing_address->zip ?>&nbsp;</dd>
			
			<dt>Country</dt>
			<dd><?php echo ORM::factory('Region', $billing_address->country)->country ?>&nbsp;</dd>
			
		<?php
				}
				if ($shipping_address->loaded())
				{
		?>
			<h5>Shipping Address</h5>
			<dt>Address</dt>
			<dd><?php echo $shipping_address->address_1 ?>&nbsp;</dd>
			
			<dt>Address2</dt>
			<dd><?php echo $shipping_address->address_2 ?>&nbsp;</dd>
			
			<dt>City</dt>
			<dd><?php echo $shipping_address->city ?>&nbsp;</dd>
			
			<dt>State</dt>
			<dd><?php echo $shipping_address->state ?>&nbsp;</dd>
			
			<dt>Zip</dt>
			<dd><?php echo $shipping_address->zip ?>&nbsp;</dd>
			
			<dt>Country</dt>
			<dd><?php echo ORM::factory('Region', $shipping_address->country)->country ?>&nbsp;</dd>
		<?php
				}
		?>
		</dl>
		<?php
			}
		?>
		
		<h4>Permissions</h4>
		<dl class="dl-horizontal well">
			<?php
				foreach ($add_edit_user->roles->find_all() as $role)
				{
			?>
			<dt><?php echo ucwords(str_replace('_', ' ', $role->name)) ?></dt>
			<dd><?php echo $role->description ?></dd>
			<?php
				}
			?>
		</dl>
	</div>
	<div class="span6">
		<h4>Activity</h4>
		<dl class="dl-horizontal well">
			<dt>Orders</dt>
			<dd>
			<?php
				$user_orders = $add_edit_user->orders->count_all();
				if ($user_orders > 0)
				{
					echo HTML::anchor('/admin_order/?user_id='.$add_edit_user->id, 'View Orders ('.$user_orders.')');
				}
				else
				{
					echo 'No orders';
				}
			?>
			</dd>
			<dt>Amount Purchased</dt>
			<dd>
			<?php
				$amount_purchased = 0;
				$user_orders = ORM::factory('Order')->where('user_id', '=', $add_edit_user->id)->find_all();
				foreach ($user_orders as $user_order)
				{
					$amount_purchased+= $user_order->total_amount;
				}
				echo Format::currency($amount_purchased);
			?>
			</dd>
			<br/>
			<dt>Shares</dt>
			<dd>
			<?php
				$page_views = ORM::factory('Share')->where('user_id', '=', $add_edit_user->id)->count_all();
				echo $page_views;
			?>
			</dd>
			
			<dt>Comments</dt>
			<dd>
			<?php
				$page_views = ORM::factory('Comments_Post')->where('user_id', '=', $add_edit_user->id)->count_all();
				echo $page_views;
			?>
			</dd>
			
			<dt>Pages Viewed</dt>
			<dd>
			<?php
				$page_views = ORM::factory('Pageview')->where('user_id', '=', $add_edit_user->id)->count_all();
				echo $page_views;
			?>
			</dd>
		</dl>
	</div>
</div>