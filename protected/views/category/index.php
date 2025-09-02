<?php
/* @var $this CategoryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Categories',
);

// $this->menu=array(
// 	array('label'=>'Create Category', 'url'=>array('create')),
// 	array('label'=>'Manage Category', 'url'=>array('admin')),
// );
?>

<h3>Categories</h3>

<?php 
// $this->widget('zii.widgets.CListView', array(
// 	'dataProvider'=>$dataProvider,
// 	'itemView'=>'_view',
// )); 
?>
<?php echo CHtml::link('Create Category', array('category/create'), array('class' => 'btn btn-info','style' => 'float: right;')); ?>
</br>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'category-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',

		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
