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
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fees'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
            [['profile_pic'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'fees' => 'Fees',
            'email' => 'Email',
            'profile_pic' => 'Profile Pic',
        ];
    }
    
    public static function generateResponseTable($model = null)
    {
        
        $rows = '';
        foreach ($model as $data) {
            $rows .= '<tr>';
            $rows .= '<th scope="row">'.$data->id.'</th>';
            $rows .= '<td>';
            $rows .= $data->name;
            $rows .= '</td>';
            $rows .= '<td>';
            $rows .= $data->fees;
            $rows .= '</td>';
            $rows .= ' <td>';
            $rows .= $data->email;
            $rows .= '</td>';
            $rows .= '<td>';
            $rows .= $data->profile_pic;
            $rows .= '</td>';
            $rows .= '<td>';
            $rows .= '<button type="button" id="'.$data->id.'" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="updateClickId()">Update</button>';
            $rows .=  '<button type="button" class="btn btn-danger" id="'.$data->id.'" onclick="DeleteClickID()">Delete</button>';
            $rows .= ' </td>';
            $rows .= '</tr>';
        }
        return $rows;
    }
}


