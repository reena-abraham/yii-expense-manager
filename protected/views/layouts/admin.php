<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

	<!-- blueprint CSS framework -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print"> -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">


	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

	<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

	<div class="container" id="page">

		<!-- <div id="header">
			<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		</div> -->

		<!-- <div id="mainmenu"> -->
		<?php
		print_r(Yii::app()->user->getState('role_id'));


		?>
		<?php
		// $this->widget('zii.widgets.CMenu', array(
		// 	'items' => array(
		// 		array('label' => 'Home', 'url' => array('/site/index')),
		// 		array('label' => 'Users', 'url' => array('/user/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->getState('role') == 1),
		// 		array('label' => 'Categories', 'url' => array('/category/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->getState('role') == 1),
		// 		array('label' => 'Expense', 'url' => array('/expense/index'), 'visible' => !Yii::app()->user->isGuest && Yii::app()->user->getState('role') == 2),
		// 		array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
		// 		array('label' => 'Register', 'url' => array('/site/register'), 'visible' => Yii::app()->user->isGuest),

		// 		array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
		// 	),
		// )); 
		?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
			<div class="container-fluid">
				<a class="navbar-brand" href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto mb-2 mb-lg-0">

						<li class="nav-item">
							<?php echo CHtml::link('Home', array('/site/index'), array('class' => 'nav-link')); ?>
						</li>

						<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getState('role') == 1): ?>
							<li class="nav-item">
								<?php echo CHtml::link('Users', array('/user/index'), array('class' => 'nav-link')); ?>
							</li>
							<li class="nav-item">
								<?php echo CHtml::link('Categories', array('/category/index'), array('class' => 'nav-link')); ?>
							</li>
						<?php endif; ?>

						<?php if (!Yii::app()->user->isGuest && Yii::app()->user->getState('role') == 1): ?>
							<li class="nav-item">
								<?php echo CHtml::link('Expense', array('/expense/admin'), array('class' => 'nav-link')); ?>
							</li>
						<?php endif; ?>

						<?php if (Yii::app()->user->isGuest): ?>
							<li class="nav-item">
								<?php echo CHtml::link('Login', array('/site/login'), array('class' => 'nav-link')); ?>
							</li>
							<li class="nav-item">
								<?php echo CHtml::link('Register', array('/site/register'), array('class' => 'nav-link')); ?>
							</li>
						<?php else: ?>
							<li class="nav-item">
								<?php echo CHtml::link('Logout (' . Yii::app()->user->name . ')', array('/site/logout'), array('class' => 'nav-link')); ?>
							</li>
						<?php endif; ?>

					</ul>
				</div>
			</div>
		</nav>



		<!-- </div> -->
		<?php if (isset($this->breadcrumbs)): ?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links' => $this->breadcrumbs,
			)); ?><!-- breadcrumbs -->
		<?php endif ?>

		<?php echo $content; ?>

		<div class="clear"></div>

		<footer class="bg-dark text-white text-center py-3 mt-5">
			<p class="mb-0">Copyright &copy; 2025 by My Company.</p>
			<p class="mb-0">All Rights Reserved.</p>
			<p class="mb-0">Powered by <a href="https://www.yiiframework.com" class="text-info">Yii Framework</a>.</p>
		</footer>

	</div>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script>
		$(document).ready(function() {
			$('#Expense_date').datepicker({
				dateFormat: 'yy-mm-dd', // Customize the date format if needed
				maxDate: 0 // Disable future dates
			});
		});
	</script>

</body>

</html>