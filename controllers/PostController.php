<?php

namespace app\controllers;

use app\models\AuthItem;
use app\models\CreatePostForm;
use app\models\Post;
use app\models\PostSearch;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete'],
                        'allow' => true,
                        'roles' => [AuthItem::ROLE_CONFIRMED],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models owned by active user.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new PostSearch();
        $searchModel->user_id = Yii::$app->user->id;
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        
        
        $formModel = new CreatePostForm();

        if (Yii::$app->request->isPost && $formModel->load(Yii::$app->request->post())) {
            $formModel->imageFile = UploadedFile::getInstance($formModel, 'imageFile');
            
            $post = $formModel->save();
            
            if ($post) {
                return $this->redirect(['view', 'id' => $post->id]);
            }
        }

        return $this->render('create', [
                    'model' => $formModel,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Returns posts pdf output
     * @param integer $id, id of post
     * @param string $destination, 'view' or 'download' 
     * @return mixed
     */
    public function actionViewPdf($id, $destination = 'view') {
        $post = $this->findModel($id);
        $content = $this->renderPartial('view', [
            'model' => $post,
        ]);

        $title = Yii::$app->name . ' / ' . $post->title;

        if ($destination == 'download') {
            return $this->renderPdf($title, $content, Pdf::DEST_DOWNLOAD);
        } else {
            return $this->renderPdf($title, $content, Pdf::DEST_BROWSER);
        }
    }

    /**
     * Generates a PDF output
     * @param string $title, the title of file
     * @param string content, the input HTML content
     * @param string destination
     * @return mixed
     */
    private function renderPdf($title, $content, $destination) {
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => $destination,
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}',
            'options' => [
                'title' => $title
            ],
            'methods' => [
                'SetHeader' => [Yii::$app->name],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);
        return $pdf->render();
    }

}
