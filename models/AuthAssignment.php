<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'item_name' => Yii::t('auth_assignment', 'Item Name'),
            'user_id' => Yii::t('auth_assignment', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getItemName() {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }

}
