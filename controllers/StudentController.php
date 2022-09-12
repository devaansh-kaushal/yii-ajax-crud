<?php
namespace app\controllers;

use app\models\Student;
use app\models\StudentSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\Response;
use yii\web\UploadedFile;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class StudentController extends Controller
{

    /**
     *
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'POST'
                    ]
                ]
            ]
        ]);
    }

    /**
     * Lists all Student models.
     *
     * @return string
     */
    public function actionUploadFile($fName = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($fName) {

            $filename = $_FILES['file']['name'];

            /* Location */
            // \Yii::$app->getBasePath()
            // D:\xampp\htdocs\basic

            $location = \Yii::$app->getBasePath()."/images/" . $filename;
            $uploadOk = 1;
            $newName = null;

            if ($uploadOk == 0) {
                echo 0;
            } else {
                /* Upload file */

                if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {

                    $newName = \Yii::$app->getBasePath()."/images/" . $fName . '-' . $filename;
                    // rename($location,$newName);
                } else {
                    return 0;
                }
            }
            $response = [];
            $response['status'] = 'OK';
            $response['location'] = $newName;
            return $response;
        }
        $response['status'] = 'NOK';
        return $response;
    }

    public function actionIndex()
    {
        // $searchModel = new StudentSearch();
        // $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider = Student::find()->all();
        $response = [];
        $response['status'] = 'NOK';

        if (isset($_POST['Student']) && ! empty($_POST['Student']) && empty($_POST['Student']['id'])) {
         
            $post = \Yii::$app->request->post();
            $name = $post['Student']['name'];
            $fees = $post['Student']['fees'];
            $email = $post['Student']['email'];
            $profile_pic = $post['Student']['profile_pic'];
            
            // $image = UploadedFile::getInstance($model, $profile_pic);
            // $image = UploadedFile::getInstanceByName('profile_pic');
            // \Yii::$app->getBasePath()."/images/" . $fName . '-' . $filename

            echo "<pre>";
            print_r($profile_pic);
            die;
                // $newName = ;
                    // rename($profile_pic,$newName);

            $return = \Yii::$app->Utility->createStudent($name, $fees, $email, $profile_pic);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response['allData'] = $dataProvider;
            if ($return) {
                $response['error'] = 'NOK';
                $response['status'] = 'OK';
                return $response;
            }
            $response['error'] = 'OK';
            return $response;
        } elseif (isset($_POST['Student']) && ! empty($_POST['Student']['id'])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = \Yii::$app->request->post();
            $id = $post['Student']['id'];
            $name = $post['Student']['name'];
            $fees = $post['Student']['fees'];
            $email = $post['Student']['email'];
            $profile_pic = $post['Student']['profile_pic'];
            $return = \Yii::$app->Utility->updateStudent($id, $name, $fees, $email, $profile_pic);
            $dataProvider = Student::find()->all();
            $response['allData'] = $dataProvider;
            if (! empty($return)) {
                $response['error'] = 'NOK';
                $response['status'] = 'OK';
                return $response;
            }
            $response['error'] = 'OK';
            return $response;
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionReloadTable()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $dataProvider = Student::find()->all();
        $rows = null;
        foreach ($dataProvider as $data) {
            $rows .= '<tr id="refresh-' . $data->id . '">';
            $rows .= '<th scope="row">' . $data->id . '</th>';
            $rows .= '<td>' . $data->name . '</td>';
            $rows .= '<td>' . $data->fees . '</td>';
            $rows .= '<td>' . $data->email . '</td>';
            $rows .= '<td>' . $data->profile_pic . '</td>';
            $rows .= '<td>';
            $rows .= '<button type="button" id="' . $data->id . '" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="updateClickId()">Update</button>';
            $rows .= '<button type="button" class="btn btn-danger" id="' . $data->id . '" onclick="DeleteClickID()">Delete</button>';
            $rows .= '</td>';
            $rows .= '</tr>';
        }
        $response['status'] = 'OK';
        $response['allData'] = $rows;
        return $response;
    }

    /**
     * Displays a single Student model.
     *
     * @param int $id
     *            ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Student model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Student();

        if ($this->request->isPost) {
            $post = \Yii::$app->request->post();
            if ($post['Student']) {
                $name = $post['Student']['name'];
                $fees = $post['Student']['fees'];
                $email = $post['Student']['email'];
                $profile_pic = $post['Student']['profile_pic'];
                $id = \Yii::$app->Utility->createStudent($name, $fees, $email, $profile_pic);

                return $this->redirect([
                    'view',
                    'id' => $id
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing Student model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *            ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        // $model = $this->findModel($id);

        // if ($this->request->isPost) {
        // $post = \Yii::$app->request->post();
        // $name = $post['Student']['name'];
        // $fees = $post['Student']['fees'];
        // $email = $post['Student']['email'];
        // $profile_pic = $post['Student']['profile_pic'];
        // $id = \Yii::$app->Utility->updateStudent($id, $name, $fees, $email, $profile_pic);
        // return $this->redirect([
        // 'view',
        // 'id' => $id
        // ]);
        // }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = [];
        $response['status'] = 'NOK';
        $post = \Yii::$app->request->post();
        if (isset($post['Student']) && isset($post['Student']['id'])) {
            $id = $post['Student']['id'];
            $model = $this->findModel($id);
            if ($model) {
                $response['status'] = 'OK';
                $response['student'] = [
                    'id' => $id,
                    'name' => $model->name,
                    'fees' => $model->fees,
                    'email' => $model->email,
                    'profile_pic' => $model->profile_pic
                ];
                return $response;
            } else {
                $response['error'] = 'OK';
                return $response;
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing Student model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *            ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        // $this->findModel($id)->delete();
        $post = \Yii::$app->request->post();
        if ($post['Student']) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $response = [];
            $response['status'] = 'NOK';
            $id = $post['Student']['id'];
            $data = \Yii::$app->Utility->deleteStudent($id);
            if ($data) {
                $response['error'] = 'NOK';
                $response['status'] = 'OK';
                return $response;
            } else {
                $response['error'] = 'OK';
                return $response;
            }
        }
        throw new \Exception('Value not deleted.....');
    }

    /**
     * Finds the Student model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *            ID
     * @return Student the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne([
            'id' => $id
        ])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
