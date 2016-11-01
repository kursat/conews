<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property User $users
 */
class AuthItem extends ActiveRecord {

    const TYPE_ROLE = 1;
    const TYPE_PERMISSON = 2;
    const ROLE_REGISTERED = 'Registered';
    const ROLE_CONFIRMED = 'Confirmed';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [

            'name' => Yii::t('auth_item', 'Name'),
            'type' => Yii::t('auth_item', 'Type'),
            'description' => Yii::t('auth_item', 'Description'),
            'rule_name' => Yii::t('auth_item', 'Rule Name'),
            'data' => Yii::t('auth_item', 'Data'),
            'childrens' => Yii::t('auth_item', 'Childrens'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAuthAssignments() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
                        ->via('userLinks');
    }

    public function getUserLinks() {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    public static function findOneByName($auth_name) {
        return AuthItem::find()->where('name=:name', ['name' => $auth_name])->one();
    }

}
