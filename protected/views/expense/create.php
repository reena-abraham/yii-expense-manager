<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->breadcrumbs=array(
	'Expenses'=>array('index'),
	'Create',
);

// $this->menu=array(
// 	array('label'=>'List Expense', 'url'=>array('index')),
// 	array('label'=>'Manage Expense', 'url'=>array('admin')),
// );
?>

<h3>Create Expense</h3>

<?php $this->renderPartial('_form', array('model'=>$model,'categories' => $categories)); ?>