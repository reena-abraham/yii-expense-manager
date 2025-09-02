<?php
/* @var $this CategoryController */
/* @var $model Category */
/* @var $form CActiveForm */
?>
<div class="container">
	<div class="row justify-content-center"> <!-- Use Bootstrap's justify-content-center for centering -->
		<div class="col-md-6"> <!-- Adjust column width as necessary -->
			<div class="form">

				<?php $form = $this->beginWidget('CActiveForm', array(
					'id' => 'category-form',
					'enableAjaxValidation' => false,
				)); ?>


				<?php echo $form->errorSummary($model); ?>

				<div class="row mb-3"> <!-- Added margin-bottom for spacing -->
					<?php echo $form->labelEx($model, 'name', array('class' => 'control-label')); ?>
					<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255), array('class' => 'form-control')); ?>
					<?php echo $form->error($model, 'name'); ?>
				</div>

				<div class="row">
					<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary btn-sm')); ?>
				</div>

				<?php $this->endWidget(); ?>

			</div><!-- form -->
		</div>
	</div>
</div>
