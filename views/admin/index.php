<div class="row-fluid">
	<div class="span12">
		<?php echo $visitor_chart; ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span4">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-file"></i>
				</span>
				<h5>Most Visited Pages</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Page</th>
							<th>Views</th>
						</tr>
					</thead>
					<tbody>
						<?php
			                foreach ($top_pages as $top_page)
			                {
			            ?>
			            <tr>
			                <td><?php echo ucfirst($top_page['page_url']) ?></td>
			                <td style="text-align: right;"><?php echo number_format($top_page['view_count']) ?></td>
			            </tr>
			            <?php
			                }
			            ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="span4">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-user"></i>
				</span>
				<h5>Users</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th></th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
			                <td>Total Users</td>
			                <td style="text-align: right;"><?php echo number_format($users) ?></td>
			            </tr>
			            <?php
			                foreach ($oauth_users as $oauth_user)
			                {
			            ?>
			            <tr>
			                <td><?php echo ucfirst($oauth_user->oauth_type) ?> Users</td>
			                <td style="text-align: right;"><?php echo number_format($oauth_user->oauth_user_count) ?></td>
			            </tr>
			            <?php
			                }
			            ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="span4">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-picture"></i>
				</span>
				<h5>Media</h5>
			</div>
			<div class="widget-content nopadding">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th></th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
			        		foreach ($media_counts as $media_count)
							{
								echo '<tr>';
					            echo '<td>Total '.Inflector::plural(ucwords($media_count->type)).'</td>';
			                	echo '<td style="text-align: right;">';
			                	echo number_format($media_count->media_count);
			                	echo '</td>';
					            echo '</tr>';
							}
						?>
			            <tr>
			                <td>Total Files</td>
			                <td style="text-align: right;"><?php echo number_format($file_count) ?></td>
			            </tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>