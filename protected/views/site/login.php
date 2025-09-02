<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4"> <!-- Center the form using Bootstrap grid system -->
            <h2>Login</h2>
            <p>Please fill out the following form with your login credentials:</p>

            <div class="form">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'login-form',
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                    ),
                )); ?>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'email', array('class' => 'control-label')); ?>
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'autocomplete' => 'off',)); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control','autocomplete' => 'off',)); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>

                <div class="form-check" style="display: none;">
                    <?php echo $form->checkBox($model, 'rememberMe', array('class' => 'form-check-input')); ?>
                    <?php echo $form->label($model, 'rememberMe', array('class' => 'form-check-label')); ?>
                </div>

                <div class="form-group">
                    <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-primary btn-sm')); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
