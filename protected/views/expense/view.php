<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	$model->id,
);

// $this->menu=array(
// 	array('label'=>'List Expense', 'url'=>array('index')),
// 	array('label'=>'Create Expense', 'url'=>array('create')),
// 	array('label'=>'Update Expense', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Expense', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Expense', 'url'=>array('admin')),
// );
?>



<?php 
// $this->widget('zii.widgets.CDetailView', array(
// 	'data'=>$model,
// 	'attributes'=>array(
// 		'amount',
// 		array(
//             'label'=>'Category',
//             'value'=>$model->category->name,  // or 'title' depending on your Category model
//         ),
// 		'description',
// 		'date',

// 	),
// )); 
?>
<div class="container mt-4">
    <h3>View Expense #<?php echo $model->id; ?></h3>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'label' => 'Amount',
                'value' => $model->amount,
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-6'),
            ),
            array(
                'label' => 'Category',
                'value' => $model->category->name,  // assuming the category relationship is defined
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-6'),
            ),
            array(
                'label' => 'Description',
                'value' => $model->description,
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-12'),
            ),
            array(
                'label' => 'Date',
                'value' => Yii::app()->dateFormatter->format('yyyy-MM-dd', $model->date),
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-6'),
            ),
        ),
        'htmlOptions' => array('class' => 'table table-bordered table-striped'),
    )); ?>
</div>

