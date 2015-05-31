<?php

namespace app\controllers\admin;

use Yii;
use app\models\News;
use app\models\search\NewsSearch;
use app\models\Category;
use app\services\news\NewsService;
use app\constants\Messages;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


class NewsController extends Controller
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
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $this->getAllCategoriesForUsingInSelect()
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'categories' => $this->getAllCategoriesForUsingInSelect()
        ]);
    }

    public function actionCreate()
    {
        $model = new News();
        
        $newsData = Yii::$app->request->post('News', null);
        if ($newsData !== null) {
            $categories = is_array($newsData['categories']) ? $newsData['categories'] : null;
            $newsService = new NewsService();
            $success = $newsService->create($model, $newsData, $categories);
            if ($success) {
                return $this->redirect(['view', 'id' => $model->id]); 
            }
        } 
        
        return $this->render('create', [
            'model' => $model,
            'categories' => $this->getAllCategoriesForUsingInSelect()
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $newsData = Yii::$app->request->post('News', null);
        if ($newsData !== null) {
            $imageFilename = Yii::$app->request->post('imageFilename', '');
            $needDeleteOldImageIfExist = $imageFilename === '';
            $categories = is_array($newsData['categories']) ? $newsData['categories'] : null;
            // Поле createdAt собираем из значений формы полей 'date' и 'time'.
            $model->setCreatedAtOnDateAndTime($newsData['date'], $newsData['time']);
            
            $newsService = new NewsService();
            $success = $newsService->update($model, $newsData, $needDeleteOldImageIfExist, $categories);
            if ($success) {
                return $this->redirect(['view', 'id' => $model->id]); 
            }
        } 
        
        return $this->render('update', [
            'model' => $model,
            'categories' => $this->getAllCategoriesForUsingInSelect()
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $newsService = new NewsService();
        $newsService->delete($model);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $newsService = new NewsService();
        $model = $newsService->getWithCategoryListById($id);
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Messages::PAGE_NOT_FOUND_404);
        }
    }
    
    private function getAllCategoriesForUsingInSelect() {
        $categories = Category::find()->asArray()->select(['id', 'title'])->all();
        $categoriesListData = ArrayHelper::map($categories, 'id', 'title');
        return $categoriesListData;
    }
   
}
