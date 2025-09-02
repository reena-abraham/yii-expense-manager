<?php
/* @var $this ExpenseController */
/* @var $dataProvider CActiveDataProvider */

// $this->breadcrumbs=array(
// 	'Expenses',
// );

// $this->menu=array(
// 	array('label'=>'Create Expense', 'url'=>array('create')),
// 	array('label'=>'Manage Expense', 'url'=>array('admin')),
// );
?>

<!-- <h1>Expenses</h1> -->

<?php 
// $this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); 
?>

<?php
/* @var $this ExpenseController */
/* @var $model Expense */

$this->breadcrumbs = array(
	'Expenses' => array('index'),
	'Manage',
);

// $this->menu = array(
// 	array('label' => 'List Expense', 'url' => array('index')),
// 	array('label' => 'Create Expense', 'url' => array('create')),
// );

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#expense-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Manage Expenses</h3>

<!-- <p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p> -->

<?php 
// echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); 
?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search', array(
		'model' => $model,
	)); ?>
</div><!-- search-form -->

<!-- Add a button to trigger the CSV export -->
<?php echo CHtml::link('Export to CSV', array('expense/exportCsv'), array('class' => 'btn btn-success')); ?>
<?php echo CHtml::link('Create Expense', array('expense/create'), array('class' => 'btn btn-info','style' => 'float: right;')); ?>

<?php echo CHtml::link('List Expense', array('expense/list'), array('class' => 'btn btn-info','style' => 'float: right;margin-right: 10px;')); ?> 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'expense-grid',
	'dataProvider' => $model->search(),
	//  'dataProvider' => $dataProvider, 
	'filter' => $model,
	'columns' => array(
		'id',
		'amount',
		array(
			'name' => 'category_id',
			'value' => '$data->category ? $data->category->name : "N/A"',
			 'filter' => CHtml::activeDropDownList($model, 'category_id', 
                CHtml::listData(Category::model()->findAll(), 'id', 'name'), 
                array('empty' => '-- Select Category --')
				 ),
		),
		'description',
		'date',

		/*
		'created_at',
		'updated_at',
		*/
		array(
			'class' => 'CButtonColumn',
		),
		
	),
	'pager' => array(
        'class' => 'CLinkPager',  // CLinkPager allows you to customize the appearance of pagination links
        'header' => '',  // Remove the "Go to page" text
        'htmlOptions' => array('class' => 'pagination'), // You can use Bootstrap's pagination styling
    ),
)); ?>
