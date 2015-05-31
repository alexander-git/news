<?php

namespace app\controllers;

use Yii;
use app\models\News;
use app\models\search\NewsPageSearch;
use app\services\category\CategoryService;
use app\constants\Messages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MainController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'news' => ['get'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new NewsPageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $category = Yii::$app->request->get('category', null);
        
        $categoryService = new CategoryService();
        $activeCategories = $categoryService->getByActive(true);
        
        return $this->render('index', [
            'newsDataProvider' => $dataProvider,
            'categories' => $activeCategories,
            'currentCategory' => $category
        ]);
    }


    public function actionNews($id)
    {
        return $this->render('news', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Messages::PAGE_NOT_FOUND_404);
        }
    }
    
}
