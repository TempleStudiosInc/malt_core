<div class="well">
    <div class="form medium_form">
        <?php
            echo Form::open('/admin_tag/save');
            echo Form::hidden('tag[id]', $tag->id);
        ?>
        <div class="form_field">
            <?php 
                echo Form::label('tag[name]', 'Name');
                echo Form::input('tag[name]', $tag->name, array('class' => 'span6'));
            ?>
        </div>
        <div class="buttons">
            <?php echo Form::button(NULL, 'Save', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
            or
            <?php echo HTML::anchor('/admin_tag/', 'Cancel', array('class' => '')) ?>
        </div>
        <?php echo Form::close(); ?>
    </div>
</div>