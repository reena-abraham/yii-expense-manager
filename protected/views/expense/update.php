<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

// $this->menu=array(
// 	array('label'=>'List Expense', 'url'=>array('index')),
// 	array('label'=>'Create Expense', 'url'=>array('create')),
// 	array('label'=>'View Expense', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Expense', 'url'=>array('admin')),
// );
?>

<h3>Update Expense <?php echo $model->id; ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model,'categories' => $categories)); ?>