<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="container mt-4">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'user-form',
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, null, null, array('class' => 'alert alert-danger')); ?>

	<div class="row mb-3">
		<div class="col-md-4">
			<?php echo $form->labelEx($model, 'name', array('class' => 'form-label')); ?>
		</div>
		<div class="col-md-8">
			<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			<?php echo $form->error($model, 'name', array('class' => 'invalid-feedback')); ?>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-md-4">
			<?php echo $form->labelEx($model, 'username', array('class' => 'form-label')); ?>
		</div>
		<div class="col-md-8">
			<?php echo $form->textField($model, 'username', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			<?php echo $form->error($model, 'username', array('class' => 'invalid-feedback')); ?>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-md-4">
			<?php echo $form->labelEx($model, 'email', array('class' => 'form-label')); ?>
		</div>
		<div class="col-md-8">
			<?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			<?php echo $form->error($model, 'email', array('class' => 'invalid-feedback')); ?>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-md-4">
			<?php echo $form->labelEx($model, 'password', array('class' => 'form-label')); ?>
		</div>
		<div class="col-md-8">
			<?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
			<?php echo $form->error($model, 'password', array('class' => 'invalid-feedback')); ?>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-md-8 offset-md-4">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
		</div>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->