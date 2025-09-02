<?php
/* @var $this CategoryController */
/* @var $model Category */

$this->breadcrumbs=array(
	'Categories'=>array('index'),
	$model->name,
);

// $this->menu=array(
// 	array('label'=>'List Category', 'url'=>array('index')),
// 	array('label'=>'Create Category', 'url'=>array('create')),
// 	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Category', 'url'=>array('admin')),
// );
?>


<?php
//  $this->widget('zii.widgets.CDetailView', array(
// 	'data'=>$model,
// 	'attributes'=>array(
// 		'id',
// 		'name',
// 		'created_at',
// 		'updated_at',
// 	),
// )); 
?>

<div class="container mt-4">
    <h3>View Category #<?php echo $model->id; ?></h3>
    <?php $this->widget('zii.widgets.CDetailView', [
        'data' => $model,
        'attributes' => [
            [
                'label' => 'Name',
                'value' => $model->name,
                'type' => 'raw',
                'htmlOptions' => ['class' => 'text-primary'],  // value styling
                'labelHtmlOptions' => ['class' => 'font-weight-bold bg-light p-2'],  // label styling
            ],
        ],
        'htmlOptions' => ['class' => 'table table-bordered table-striped table-hover'],
    ]); ?>
</div>

