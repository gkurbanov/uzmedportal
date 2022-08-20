<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_subscribe".
 *
 * @property int $id
 * @property string $added_at
 * @property string $first_name
 * @property string|null $email
 */
class EmailSubscribe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'email_subscribe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['added_at'], 'safe'],
            [['first_name'], 'required'],
            [['first_name', 'email'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'added_at' => 'Время подачи',
            'first_name' => 'Имя',
            'email' => 'Email',
        ];
    }
}
