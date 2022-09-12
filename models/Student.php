<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $fees
 * @property string|null $email
 * @property string|null $profile_pic
 */
class Student extends \yii\db\ActiveRecord
{

    /**
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'fees'
                ],
                'integer'
            ],
            [
                [
                    'name'
                ],
                'string',
                'max' => 50
            ],
            [
                [
                    'email'
                ],
                'string',
                'max' => 100
            ]
            // [
            //     [
            //         'profile_pic'
            //     ],
            //     'file',
            //     'extensions' => 'png, jpg, jpeg',
            //     // 'max' => 500
            //     'maxFiles' => 4,
            //     'maxSize' => 1024 * 1024 * 2
            // ]
        ];
    }

    /**
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'fees' => 'Fees',
            'email' => 'Email',
            'profile_pic' => 'Profile Pic'
        ];
    }
}
