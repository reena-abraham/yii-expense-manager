<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array(
				'class' => 'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest) {
			$this->render('index');
		} else {
			if (Yii::app()->user->getState('role') == 1) {
				$this->redirect(array('site/adminDashboard'));
			} else {
				$this->redirect(array('site/userDashboard'));
			}
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;
		if (isset($_POST['ContactForm'])) {
			$model->attributes = $_POST['ContactForm'];
			if ($model->validate()) {
				$name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
				$subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
				$headers = "From: $name <{$model->email}>\r\n" .
					"Reply-To: {$model->email}\r\n" .
					"MIME-Version: 1.0\r\n" .
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
				Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact', array('model' => $model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->homeUrl); // or any other page you want to redirect to
			return; // stop further execution
		}
		$model = new LoginForm;

		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login()) {
				$user = User::model()->findByPk(Yii::app()->user->id);
				$roles = $user->roles;
				if (!empty($roles)) {
					$role = $roles[0];
					if ($role->id == 1) {
						$this->redirect(array('site/adminDashboard'));
					} elseif ($role->id == 2) {
						$this->redirect(array('site/userDashboard'));
					} else {
						$this->redirect(Yii::app()->user->returnUrl);
					}
				} else {
					throw new CHttpException(403, "No role assigned to this user.");
				}
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	public function actionRegister()
	{
		if (!Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->homeUrl);
			return;
		}

		$model = new User('register');

		if (isset($_POST['User'])) {
			$model->attributes = $_POST['User'];

			if ($model->validate()) {
				// Set additional attributes before saving
				$model->password = CPasswordHelper::hashPassword($model->password);
				$model->created_at = date('Y-m-d H:i:s');
				if ($model->save()) {
					Yii::app()->db->createCommand()->insert('user_roles', array(
						'user_id' => $model->id,
						'role_id' => 2,
					));

					Yii::app()->user->setFlash('message', 'Registration successful');
					$this->redirect(array('site/login'));
				} else {
					Yii::app()->user->setFlash('error', 'Registration failed');
				}
			} else {
				// Clear password on validation failure
				$model->password = '';
			}
		}

		$this->render('register', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}



	public function actionAdminDashboard()
	{
		// Only allow admin
		if (Yii::app()->user->getState('role') != 1) {
			throw new CHttpException(403, 'Unauthorized access');
		}

		$this->render('admin_dashboard');
	}

	public function actionUserDashboard()
	{
		// Only allow user
		if (Yii::app()->user->getState('role') != 2) {
			throw new CHttpException(403, 'Unauthorized access');
		}
		$startDate = date('Y-m-01');
		$endDate = date('Y-m-t');
		$userId = Yii::app()->user->id;
		$user = User::model()->findByPk($userId);
		
		$totalSpentData = Yii::app()->db->createCommand()
			->select('SUM(amount) AS total_spent')
			->from('expense')
			->where('user_id = :userId AND date BETWEEN :startDate AND :endDate', array(':userId' => $userId,':startDate' => $startDate, ':endDate' => $endDate))  // Filter by date range
			->queryRow();
		$totalSpent = $totalSpentData ? $totalSpentData['total_spent'] : 0;

		$mostExpensiveCategory = Yii::app()->db->createCommand()
			->select('c.name AS category_name, SUM(e.amount) AS total')
			->from('expense e')
			->join('category c', 'e.category_id = c.id')
			->where('e.user_id = :userId', [':userId' => $userId])
			->group('e.category_id')
			->order('total DESC')
			->limit(1)
			->queryRow();

		$categoryName = $mostExpensiveCategory ? $mostExpensiveCategory['category_name'] : '';

		$categoriesData = Yii::app()->db->createCommand()
			->select('c.name AS category_name, SUM(e.amount) AS total')
			->from('expense e')
			->join('category c', 'e.category_id = c.id')
			->where('e.user_id = :userId', [':userId' => $userId])
			->group('e.category_id')
			->queryAll();
		// print_r($categoriesData);exit;
		$labels = [];
		$data = [];
		foreach ($categoriesData as $category) {
            $labels[] = $category['category_name'];
            $data[] = (float)$category['total'];
        }
		$this->render('user_dashboard', array(
			'totalSpent' => $totalSpent, 
			'mostExpensiveCategory' => $categoryName,
			'labels' => $labels,
            'data' => $data,
			'user'=>$user
		));
	}
}
