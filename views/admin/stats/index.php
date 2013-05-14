<?php
	echo HTML::script('_media/core/common/js/Chart.min.js');
?>

<div class="row-fluid">
	<div class="span4">
		<h4><?php echo ucwords(str_replace('_', ' ', $form['facet'])) ?></h4>
	</div>
	<div class="span8">
		<?php
			echo Form::open('/admin_stats', array('method' => '_GET', 'class' => 'form-inline'));
			echo Form::select('facet', $facets, $form['facet'], array('style' => 'width:20%;'));
		?>
			<div class="input-prepend input-append">
				<span class="add-on"><i class="icon-calendar"></i></span>
				<?php
					echo Form::input('date_range', $form['date_range'], array('id' => 'date_range'));
					echo Form::button('search', 'GO', array('class' => 'btn'));
				?>
			</div>
		<?php
			echo Form::close();
		?>
	</div>
</div>
<div class="row-fluid">
	<?php echo $facet_view ?>
</div>

<script>
	$(function() {
    	$('#date_range').daterangepicker({
	        ranges: {
	            'Today': ['today', 'today'],
	            'Yesterday': ['yesterday', 'yesterday'],
	            'Last 7 Days': [Date.today().add({ days: -6 }), 'today'],
	            'Last 30 Days': [Date.today().add({ days: -29 }), 'today'],
	            'This Month': [Date.today().moveToFirstDayOfMonth(), Date.today().moveToLastDayOfMonth()],
	            'Last Month': [Date.today().moveToFirstDayOfMonth().add({ months: -1 }), Date.today().moveToFirstDayOfMonth().add({ days: -1 })]
        	}
        });
	})
</script>