<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo __("Please Sign In") ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('User', array(
                        'role' => 'form'
                    )); ?>
                        <fieldset>
                            <div class="form-group">
                             <?php
                        echo $this->Form->input('username', array(
                            'label' => false,
                            'class' => 'form-control',
							'div'=>false,
							'placeholder'=> __("E-mail")
                        ));?>
                            </div>
                            <div class="form-group">
                             <?php
                        echo $this->Form->input('password', array(
                            'label' => false,
                            'class' => 'form-control',
							'div'=>false,
							'placeholder'=> __("Password")
                        ));?>
                            </div>
                           
                            <div class="checkbox">
                                <label>
                                     <?php echo $this->Form->checkbox('rememberMe');?>
                                     <?php echo __("Remember Me") ?>
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                        </fieldset>
                       <?php echo $this->Form->end(array(
                            'label' => __('Login'),
                            'class' => 'btn btn-lg btn-success btn-block',
                        )); ?>
                </div>
            </div>
        </div>
    </div>
</div>