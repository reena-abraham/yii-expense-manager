<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			// array(
			// 	'allow',
			// 	'actions' => array('adminDashboard'),
			// 	'expression' => 'Yii::app()->user->getState("role") == 1',
			// ),
			// array(
			// 	'allow',
			// 	'actions' => array('userDashboard'),
			// 	'expression' => 'Yii::app()->user->getState("role") == 2',
			// ),
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'expression' => 'Yii::app()->user->getState("role") == 1',
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update'),
				'expression' => 'Yii::app()->user->getState("role") == 1',
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('admin', 'delete'),
				'expression' => 'Yii::app()->user->getState("role") == 1',
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new User('create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];


			if ($model->validate()) {
				$model->password = CPasswordHelper::hashPassword($model->password);
				$model->role_id = 2;
				$model->created_at = date('Y-m-d H:i:s'); // Set current timestamp manually
				if ($model->save()) {
					Yii::app()->db->createCommand()->insert('user_roles', array(
						'user_id' => $model->id,
						'role_id' => $model->role_id
					));
					$this->redirect(array('view', 'id' => $model->id));
				}
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider = new CActiveDataProvider('User');
		// $dataProvider = new CActiveDataProvider('User', array(
		// 	'criteria' => array(
		// 		'join' => 'JOIN user_roles ur ON t.id = ur.user_id',  // Join user_roles table
		// 		'condition' => 'ur.role_id = 2', // Filter users with role_id = 2
		// 	),
		// ));
		// $this->render('index', array(
		// 	'dataProvider' => $dataProvider,
		// ));
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		// Adding a filter to search only users with role_id = 2
		$criteria = new CDbCriteria;
		$criteria->join = 'INNER JOIN user_roles ur ON ur.user_id = t.id'; // Join with user_roles table
		$criteria->condition = 'ur.role_id = 2'; // Filter by role_id = 2

		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];

		// Pass the criteria to the data provider
		$model->setDbCriteria($criteria);

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		// Adding a filter to search only users with role_id = 2
		$criteria = new CDbCriteria;
		$criteria->join = 'INNER JOIN user_roles ur ON ur.user_id = t.id'; // Join with user_roles table
		$criteria->condition = 'ur.role_id = 2'; // Filter by role_id = 2

		if (isset($_GET['User']))
			$model->attributes = $_GET['User'];

		// Pass the criteria to the data provider
		$model->setDbCriteria($criteria);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = User::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	// public function actionAdminDashboard()
	// {
	// 	// Only allow admin
	// 	if (Yii::app()->user->getState('role') != 1) {
	// 		throw new CHttpException(403, 'Unauthorized access');
	// 	}

	// 	$this->render('admin_dashboard');
	// }

	// public function actionUserDashboard()
	// {
	// 	// Only allow user
	// 	if (Yii::app()->user->getState('role') != 2) {
	// 		throw new CHttpException(403, 'Unauthorized access');
	// 	}
	// 	$startDate = date('Y-m-01');
	// 	$endDate = date('Y-m-t');

	// 	$totalSpentData = Yii::app()->db->createCommand()
	// 		->select('SUM(amount) AS total_spent')
	// 		->from('expense')
	// 		->where('date BETWEEN :startDate AND :endDate', array(':startDate' => $startDate, ':endDate' => $endDate))  // Filter by date range
	// 		->queryRow();
	// 	$totalSpent = $totalSpentData ? $totalSpentData['total_spent'] : 0;

	// 	$mostExpensiveCategory = Yii::app()->db->createCommand()
	// 		->select('c.name AS category_name, SUM(e.amount) AS total')
	// 		->from('expense e')
	// 		->join('category c', 'e.category_id = c.id')
	// 		->group('e.category_id')
	// 		->order('total DESC')
	// 		->limit(1)
	// 		->queryRow();

	// 	$categoryName = $mostExpensiveCategory ? $mostExpensiveCategory['category_name'] : '';
	// 	$this->render('user_dashboard', array('totalSpent' => $totalSpent, 'mostExpensiveCategory' => $categoryName,));
	// }
}
