<?php
	echo HTML::script('_media/core/common/js/Chart.min.js');
	$unique_chart_id = uniqid();
?>

<div id="bar_chart_container_<?php echo $unique_chart_id ?>" class="well" style="background:white;">
	<h3><?php echo $chart_title ?></h3>
	<canvas id="bar_chart_<?php echo $unique_chart_id ?>" width="800" height="300"></canvas>
</div>
<?php
	$labels = array();
	$data = array();
	foreach ($stats as $stat_label => $stat_data)
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