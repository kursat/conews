<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 *
 */
class AuthItemChild extends ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'auth_item_child';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'parent' => Yii::t('auth_item_child', 'Parent'),
            'child' => Yii::t('auth_item_child', 'Child'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getParentAuthItem() {
        return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
    }

    /**
     * @return ActiveQuery
     */
    public function getChildAuthItem() {
        return $this->hasOne(AuthItem::className(), ['name' => 'child']);
    }

}
