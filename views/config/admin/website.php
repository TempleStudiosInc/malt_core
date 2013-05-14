<h1><?php ucfirst($group) ?> Config</h1>
<br/>
<?php
	echo Form::open('/admin_config/'.$group, array('class' => 'well'));
	
	foreach ($configs as $key => $config)
	{
	    $config_value = $config;
        
	    $config = DB::select()->from('config')->where('group_name', '=', $group)->where('config_key', '=', $key)->execute();
        $config = $config[0];
        
		echo '<div>';
		echo Form::label($group.'['.$key.']', $config['label']);
        switch ($config['field_type'])
        {
            case 'text':
                echo Form::input($group.'['.$key.']', $config_value, array('class' => 'span3'));
                break;
            case 'select':
                $options_value = $group.'_'.$key.'_options';
                echo Form::select($group.'['.$key.']', $$options_value, $config_value, array('class' => 'span3'));
                break;
        }
		echo '</div>';
	}
	
	echo '<br/>';
    echo Form::submit(NULL, 'Save', array('class' => 'btn btn-success'));
    echo '&nbsp;&nbsp;<small>or</small>&nbsp;&nbsp;';
    echo HTML::anchor('/admin_config/'.$group, 'cancel');
	
	echo Form::close();
?>