<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Expense[] $expenses
 * @property UserRoles[] $userRoles
 */
class User extends CActiveRecord
{
	 public $role_id;  
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// Registration rules
			array('name, username,email, password', 'required', 'on' => 'register'),
			array('email', 'email'),
			array('email', 'email', 'on' => 'register'),
			array('password', 'length', 'min' => 6, 'on' => 'register', 'message' => 'Password must be at least 6 characters long.'),

			// Login rules
			array('email, password', 'required', 'on' => 'login'),

			// Create rules for creating a new user (for user/create action)
			array('name, username, email, password', 'required', 'on' => 'create'),
			array('email', 'email', 'on' => 'create'),
			array('password', 'length', 'min' => 6, 'on' => 'create', 'message' => 'Password must be at least 6 characters.'),

			// Common or safe attributes
			array('name, username,email, password', 'safe'),

			// array('name, username, password, email', 'required'),
			// array('name, username, password, email', 'length', 'max'=>255),
			// array('created_at, updated_at', 'safe'),
			// // The following rule is used by search().
			// // @todo Please remove those attributes that should not be searched.
			// array('id, name, username, password, email, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'expenses' => array(self::HAS_MANY, 'Expense', 'user_id'),
			'userRoles' => array(self::HAS_MANY, 'UserRoles', 'user_id'),
			'roles' => array(self::MANY_MANY, 'Role', 'user_roles(user_id, role_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('email', $this->email, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	protected function beforeSave()
	{
		if ($this->isNewRecord) {
			// Set created_at only when the record is being created
			$this->created_at = new CDbExpression('NOW()');
		}

		// Always update updated_at on save
		$this->updated_at = new CDbExpression('NOW()');

		return parent::beforeSave();
	}
}
