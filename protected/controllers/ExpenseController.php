<?php

class ExpenseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
			array(
				'allow',  // allow all users to perform 'index' and 'view' actions
				'actions' => array('index', 'view'),
				'users' => array('*'),
			),
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('create', 'update', 'admin', 'delete', 'ExportCsv', 'list'),
				'users' => array('@'),
			),
			// array(
			// 	'allow', // allow admin user to perform 'admin' and 'delete' actions
			// 	'actions' => array('admin', 'delete'),
			// 	'users' => array('admin'),
			// ),
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
		$model = new Expense;
		$categories = CHtml::listData(Category::model()->findAll(), 'id', 'name');
		// If the form is submitted
		if (isset($_POST['Expense'])) {
			$model->attributes = $_POST['Expense'];
			$model->user_id = Yii::app()->user->id;

			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Expense added successfully');
				$this->redirect(array('view', 'id' => $model->id));  // Redirect to the expense view page
			}
		}

		// Render the form view, passing the model and categories
		$this->render('create', array(
			'model' => $model,
			'categories' => $categories,  // Pass categories here
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
		$categories = CHtml::listData(Category::model()->findAll(), 'id', 'name');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Expense'])) {
			$model->attributes = $_POST['Expense'];
			$model->user_id = Yii::app()->user->id;
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
		}

		$this->render('update', array(
			'model' => $model,
			'categories' => $categories,
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

		// $totalSpent = Expense::model()->sum('amount', $criteria);

		// $dataProvider = new CActiveDataProvider('Expense');
		// $dataProvider = new CActiveDataProvider('Expense', array(
		// 	'pagination' => array(
		// 		'pageSize' => 1,  // Number of records to display per page
		// 	),
		// ));

		// $this->render('index', array(
		// 	'dataProvider' => $dataProvider,
		// ));

		// 	 $dataProvider = new CActiveDataProvider('Expense', array(
		//     'pagination' => array(
		//         'pageSize' => 10,  // Number of records to display per page
		//     ),
		// ));

		$model = new Expense('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Expense'])) {
			$model->attributes = $_GET['Expense'];
		}
		$this->render('index', array(
			//  'dataProvider' => $dataProvider,
			'model' => $model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Expense('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Expense'])) {
			$model->attributes = $_GET['Expense'];
		}
		$this->render('admin', array(
			'model' => $model,
		));
	}
	public function actionList()
	{
		// $dataProvider = new CActiveDataProvider('Expense', array(
		// 	'pagination' => array(
		// 		'pageSize' => 1,  // Number of records to display per page
		// 	),
		// ));
		$dataProvider = new CActiveDataProvider('Expense', array(
			'criteria' => array(
				'condition' => 'user_id = :user_id',  // Filter by the logged-in user
				'params' => array(':user_id' => Yii::app()->user->id),  // Bind the user ID parameter
			),
			'pagination' => array(
				'pageSize' => 1,  // Number of records to display per page
			),
		));

		$this->render('list', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Expense the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Expense::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Expense $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'expense-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionExportCsv()
	{
		// 	Yii::app()->layout = false;
		// 	Yii::import('ext.EExcelView.EExcelView');

		// 	$criteria = new CDbCriteria();
		// 	$criteria->select = 'id, amount, category_id, description, date';
		// 	$criteria->order = 'date DESC';
		// 	$criteria->condition = 'user_id = :userId';
		// 	$criteria->params = array(':userId' => Yii::app()->user->id);

		// 	$dataProvider = new CActiveDataProvider('Expense', array(
		// 		'criteria' => $criteria,
		// 		'pagination' => false,
		// 	));


		// 	$_GET['exportType'] = 'CSV';

		// 	$this->widget('ext.EExcelView.EExcelView', array(
		// 		'dataProvider' => $dataProvider,
		// 		'title' => 'Expenses Report',
		// 		'filename' => 'expenses_report',
		// 		'exportType' => 'CSV',
		// 		'columns' => array(
		// 			'id',
		// 			'amount',
		// 			array(
		// 				'name' => 'category.name',
		// 				'header' => 'Category',
		// 			),
		// 			'description',
		// 			'date',
		// 		),
		// 	));

		// 	Yii::app()->end();
		// }
		// Fetch all expenses from the database (You can modify this query to filter as needed)
		$criteria = new CDbCriteria;
		$criteria->select = 'id, amount, category_id, description, date'; // Select the relevant columns
		$criteria->order = 'date DESC'; // Order by date (can modify as per need)
		$expenses = Expense::model()->findAll($criteria);

		// Create a CSV file and open it for writing
		$csv = fopen('php://output', 'w');

		// Set the correct headers to trigger CSV download in the browser
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="expenses.csv"');
		header('Pragma: no-cache');
		header('Expires: 0');

		// Write the column headers to the CSV
		fputcsv($csv, array('ID', 'Amount', 'Category', 'Description', 'Date'));

		// Write the expense data to the CSV
		foreach ($expenses as $expense) {
			// Get the category name based on category_id
			$category = Category::model()->findByPk($expense->category_id);
			$categoryName = $category ? $category->name : 'N/A';

			// Prepare the data row
			$row = array(
				$expense->id,
				$expense->amount,
				$categoryName,
				$expense->description,
				$expense->date
			);

			// Write the row to the CSV file
			fputcsv($csv, $row);
		}

		// Close the CSV file
		fclose($csv);

		Yii::app()->end();
	}
}
