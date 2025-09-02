<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'expense-form',
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'amount'); ?>
            <?php
            echo CHtml::tag('input', array(
                'type' => 'number',
                'name' => CHtml::activeName($model, 'amount'),
                'value' => CHtml::encode($model->amount),
                'step' => '0.01',
                'min' => '0',
                'autocomplete' => 'off',
                'class' => 'form-control',
                'id' => CHtml::activeId($model, 'amount'),
            ));
            ?> <?php echo $form->error($model, 'amount'); ?>
        </div>

        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'category_id'); ?>
            <?php echo $form->dropDownList($model, 'category_id', $categories, ['prompt' => 'Select Category', 'class' => 'form-control']); ?>
            <?php echo $form->error($model, 'category'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50, 'class' => 'form-control')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>

        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'date'); ?>
            <?php
            // Using CJuiDatePicker widget for the date field
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'yy-mm-dd',
                ),
                'htmlOptions' => array(
                    'size' => '10',
                    'maxlength' => '10',
                    'autocomplete' => 'off',
                    'class' => 'form-control',
                ),
            ));
            ?>
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->