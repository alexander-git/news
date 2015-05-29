<?php

namespace app\controllers\admin;

use Yii;
use app\models\News;
use app\models\search\NewsSearch;
use app\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use app\services\news\NewsService;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $this->getAllCategoriesForUsingInSelect()
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'categories' => $this->getAllCategoriesForUsingInSelect()
        ]);
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        if ($model->load(Yii::$app->request->post() && $model->save() ) ) {
            
            Yii::error(print_r(Yii::$app->request->post(), true) );
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'create', 
                [
                    'model' => $model,
                    'categories' => $this->getAllCategoriesForUsingInSelect()
                ]
            );
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'update', 
                [
                    'model' => $model,
                    'categories' => $this->getAllCategoriesForUsingInSelect()
                ]
            );
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = News::find($id)->with('category')->one();
        
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Страницы не существует.');
        }
    }
    
    private function getAllCategoriesForUsingInSelect() {
        // TODO# разобрать.
        $categories = Category::find()->asArray()->select(['id', 'title'])->all();
        $categoriesListData = ArrayHelper::map($categories, 'id', 'title');
        return $categoriesListData;
    }
   
}
