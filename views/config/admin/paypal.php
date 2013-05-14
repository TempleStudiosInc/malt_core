<h1>Paypal Config</h1>

<?php
    echo Form::open('/admin_config/paypal', array('class' => 'well'));
    
    foreach ($configs as $key => $config)
    {
            echo '<div>';
            echo Form::label('paypal['.$key.']', ucwords(str_replace('_', ' ', $key)));
            echo Form::input('paypal['.$key.']', $config, array('class' => 'span3'));
            echo '</div>';
    }
    
    echo '<br/>';
    echo Form::submit(NULL, 'Save', array('class' => 'btn btn-success'));
    echo '&nbsp;&nbsp;<small>or</small>&nbsp;&nbsp;';
    echo HTML::anchor('/admin_config/paypal', 'cancel');
    
    echo Form::close();
?>