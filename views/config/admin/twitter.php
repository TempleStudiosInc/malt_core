<h1>Twitter Config</h1>
<br/>
<?php
	echo Form::open('/admin_config/twitter', array('class' => 'well'));
	
	foreach ($configs as $key => $config)
	{
		echo '<div>';
		echo Form::label('twitter['.$key.']', ucwords(str_replace('_', ' ', $key)));
		echo Form::input('twitter['.$key.']', $config, array('class' => 'span3'));
		echo '</div>';
	}
    
	echo '<br/>';
	echo Form::submit(NULL, 'Save', array('class' => 'btn btn-success'));
	echo '&nbsp;&nbsp;<small>or</small>&nbsp;&nbsp;';
    echo HTML::anchor('/admin_config/twitter', 'cancel');
	
	echo Form::close();
?>