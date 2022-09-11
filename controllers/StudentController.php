<?php
namespace app\controllers;

use app\models\Student;
use app\models\StudentSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\base\Response;

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
    public function actionIndex()
    {
        // $searchModel = new StudentSearch();
        // $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider = Student::find()->all();
        $response = [];
        $response['status'] = 'NOK';
        if (isset($_POST['Student']) && ! empty($_POST['Student']) && empty($_POST['Student']['id'])) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = \Yii::$app->request->post();
            $name = $post['Student']['name'];
            $fees = $post['Student']['fees'];
            $email = $post['Student']['email'];
            $profile_pic = $post['Student']['profile_pic'];
            $return = \Yii::$app->Utility->createStudent($name, $fees, $email, $profile_pic);
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
            $allData = Student::generateResponseTable($dataProvider);
         
            
            if (! empty($return)) {
                $response['status'] = 'OK';
                $response['allData'] = $allData;
                return $response;
            }
            $response['error'] = 'OK';
            return $response;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
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
