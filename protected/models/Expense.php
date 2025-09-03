<?php

/**
 * This is the model class for table "expense".
 *
 * The followings are the available columns in table 'expense':
 * @property string $id
 * @property string $amount
 * @property string $category_id
 * @property string $description
 * @property string $date
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property Category $category
 * @property User $user
 */
class Expense extends CActiveRecord
{
	public $date_from;
	public $date_to;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'expense';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, category_id, date, user_id', 'required'),
			array('amount', 'numerical', 'integerOnly' => false),
			array('amount', 'numerical', 'min' => 0),

			array('category_id, user_id', 'length', 'max' => 11),
			array('description, created_at, updated_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, amount, category, description, date_from, date_to', 'safe', 'on' => 'search'),
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
			'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'amount' => 'Amount',
			'category_id' => 'Category',
			'description' => 'Description',
			'date' => 'Date',
			'user_id' => 'User',
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
		if (Yii::app()->user->getState('role') == 2) {
			$criteria->compare('user_id', Yii::app()->user->id);
		}


		$criteria->compare('id', $this->id, true);
		$criteria->compare('amount', $this->amount, true);
		// $criteria->compare('category_id',$this->category_id,true);

		$criteria->compare('description', $this->description, true);
		$criteria->compare('date', $this->date, true);
		// $criteria->compare('user_id', $this->user_id, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);

		if ($this->category_id) {
			// print_r('d');
			// $criteria->with = array('category');
			$criteria->compare('category_id', $this->category_id);
		}
		if (!empty($this->date_from) && !empty($this->date_to)) {
			$criteria->addBetweenCondition('date', $this->date_from, $this->date_to);
		} elseif (!empty($this->date_from)) {
			$criteria->addCondition("date >= '{$this->date_from}'");
		} elseif (!empty($this->date_to)) {
			$criteria->addCondition("date <= '{$this->date_to}'");
		}

		//$command = Yii::app()->db->commandBuilder->createFindCommand($this->tableName(), $criteria);
		//Yii::log('Generated SQL query: ' . $command->getText(), 'info');
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 1, // Change as needed
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Expense the static model class
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
