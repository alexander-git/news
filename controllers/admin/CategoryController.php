<?php

namespace app\controllers\admin;

use Yii;
use app\models\Category;
use app\models\search\CategorySearch;
use app\services\category\CategoryService;
use app\constants\Messages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CategoryController extends Controller
{
    public $layout = 'admin';
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'delete' => ['post']
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        $categoryData = Yii::$app->request->post('Category', null);
        if ($categoryData !== null) {
            $categoryService = new CategoryService();
            $success = $categoryService->create($model, $categoryData);
            if ($success) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $categoryData = Yii::$app->request->post('Category', null);
        if ($categoryData !== null) {
            $categoryService = new CategoryService();
            $success = $categoryService->update($model, $categoryData);
            if ($success) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $categoryService = new CategoryService();
        $categoryService->delete($model);

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $categoryService = new CategoryService();
        $model = $categoryService->getById($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Messages::PAGE_NOT_FOUND_404);
        }
    }
    
}
