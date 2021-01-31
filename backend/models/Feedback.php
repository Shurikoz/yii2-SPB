<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string|null $phone
 * @property string|null $message
 * @property int $created_at
 * @property int $updated_at
 */
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'message'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['phone', 'message'], 'string'],
            ['email', 'email'],
            [['created_at', 'updated_at'], 'integer'],
            [['email', 'name'], 'string', 'max' => 255],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6LfKlUIaAAAAAO4fizW9O1gJNISzRc0K_vZ8qYiN']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'phone' => 'Phone',
            'message' => 'Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Sends an email.
     *
     * @return bool whether the email was send
     */
    public function sendFeedbackEmail()
    {
        return Yii::$app->mailer
            ->compose('feedbackForm', [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'message' => $this->message
            ])
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Feedback form')
            ->send();
    }

}
