<?php
	$pageviews_stats_orm = ORM::factory('Pageview')->get_pageviews($params);
	
	$pageviews_stats = array();
	foreach ($pageviews_stats_orm as $stat)
	{
		$pageviews_stats[$stat->date_viewed_group] = (int) $stat->view_count;
	}
?>

<div class="span4">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th style="text-align:right;">Views</th>
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($pageviews_stats as $date => $views)
			{
				echo '<tr>';
				echo '<td>'.$date.'</td>';
				echo '<td style="text-align:right;">'.number_format($views).'</td>';
				echo '</tr>';
			}
		?>
		</tbody>
	</table>
</div>
<div class="span8">
	<?php
		$unique_chart_id = uniqid();
	?>
	<div id="bar_chart_container_<?php echo $unique_chart_id ?>" class="well" style="background:white;">
		<canvas id="bar_chart_<?php echo $unique_chart_id ?>" width="800" height="300"></canvas>
	</div>
	<?php
		$labels = array();
		$data = array();
		foreach ($pageviews_stats as $stat_label => $stat_data)
		{
			
			$labels[] = $stat_label;
			$data[] = $stat_data;
		}
	?>
	<script>
		var lineChartData = {
			labels : <?php echo json_encode($labels); ?>,
			datasets : [{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : <?php echo json_encode($data); ?>,
					datasetFill : false
			}]
		}
		
		$(function () {
			var chart_1 = new Chart($('#bar_chart_<?php echo $unique_chart_id ?>').get('0').getContext('2d')).Line(lineChartData);
		})
	</script>
</div>