<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
);

// $this->menu=array(
// 	array('label'=>'List User', 'url'=>array('index')),
// 	array('label'=>'Create User', 'url'=>array('create')),
// 	array('label'=>'Update User', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete User', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage User', 'url'=>array('admin')),
// );
?>



<?php 
// $this->widget('zii.widgets.CDetailView', array(
// 	'data'=>$model,
// 	'attributes'=>array(
// 		'id',
// 		'name',
// 		'username',
// 		'email',
		
// 	),
// ));
 ?>
 <div class="container mt-4">
    <h3>View User #<?php echo $model->id; ?></h3>
    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            array(
                'label' => 'Name',
                'value' => $model->name,
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-6'),
            ),
            array(
                'label' => 'Username',
                'value' => $model->username,  // assuming the category relationship is defined
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-6'),
            ),
            array(
                'label' => 'Email',
                'value' => $model->email,
                'type' => 'raw',
                'htmlOptions' => array('class' => 'col-md-12'),
            ),
     
        ),
        'htmlOptions' => array('class' => 'table table-bordered table-striped'),
    )); ?>
</div>
