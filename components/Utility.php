<?php
namespace app\components;

use Yii;
use yii\base\Component;

class Utility extends Component
{

    public function createStudent($name = null, $fees = null, $email = null, $profile_pic = null)
    {
        $id = null;
        if (! empty($name) && ! empty($fees) && ! empty($email) && ! empty($profile_pic)) {
            $connection = Yii::$app->db;
            $connection->open();
            $sql = 'CALL create_student(:name,:fees,:email,:profile_pic);';

            $command = $connection->createCommand($sql);
            $command->bindValue(':name', $name);
            $command->bindValue(':fees', $fees);
            $command->bindValue(':email', $email);
            $command->bindValue(':profile_pic', $profile_pic);
            $data = $command->queryOne();
            return $data['outid'];
        }
    }

    public function deleteStudent($id = null)
    {
        if ($id) {
            $connection = Yii::$app->db;
            $connection->open();
            $sql = 'CALL delete_student(:id);';
            $command = $connection->createCommand($sql);
            $command->bindValue(':id', $id);
            $data = $command->execute();
            if ($data) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function updateStudent($id = null, $name = null, $fees = null, $email = null, $profile_pic = null)
    {
        if ($id) {
            $connection = Yii::$app->db;
            $connection->open();
            $sql = 'CALL update_student(:id,:name,:fees,:email,:profile_pic);';
            $command = $connection->createCommand($sql);
            $command->bindValue(':id', $id);
            $command->bindValue(':name', $name);
            $command->bindValue(':fees', $fees);
            $command->bindValue(':email', $email);
            $command->bindValue(':profile_pic', $profile_pic);
            $data = $command->queryOne();
            // return $data['outid'];
            return true;
        }
        return false;
    }

    public function createUser($userName = null, $passWord = null)
    {
        if (! empty($userName) && ! empty($passWord)) {
            $connection = Yii::$app->db;
            $connection->open();
            $sql = 'CALL create_user(:username,:password);';
            $command = $connection->createCommand($sql);
            $command->bindValue(':username', $userName);
            $command->bindValue(':password', $passWord);
            $data = $command->execute();
            if ($data) {
                return true;
            }
            return false;
        }
        return false;
    }
}
