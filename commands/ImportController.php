<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Json;

use app\models\Category;
use app\models\News;
use app\models\CategoryNews;

class ImportController extends Controller
{
    // Формат даты в Json - файле.
    const DATE_FORMAT = 'Y-m-d';
    
    public $filename = 'base.json';
    // Опция manyToMany отвечает за то как связивать категории с новстями.
    // Если она равна true, то новость будет связанас со всем родительским 
    // категориям. Однако при этом если категория не активна, то все её новости и
    // дочерние категории вместе с новостями импортированны не будут.
    // Если опция равна false, то новость будет иметь только одну категорию. 
    // Дочерние активные категории для неактивной категории при этом  
    // будут импортированны.
    public $manyToMany = false;
    
    private $categoriesData = [];
    private $categoryNewsData = [];
    private $newsData = [];
    private $images = [];
    
    public function options($actionId) {
        $options = [
            'index' => ['filename', 'manyToMany'],
            '' => ['filename', 'manyToMany']
        ];
        return $options[$actionId];
    }
    
    public function actionIndex()
    {
        $json = file_get_contents($this->filename);
        
        $rootCategories = Json::decode($json);
        foreach($rootCategories as $c) {
            $this->importCategory($c, []);
        }
        
        $this->insertCategories();
        $this->insertNews();
        $this->insertCategoryNews();
        $this->uploadImages();
        
        return 0;
    }
    
    private function importCategory($category, $idParentCategories) {
        if (!$category['active'] && $this->manyToMany) {
            return;
        }
        
        if ($category['active']) {
            $this->prepareCategory($category);
            foreach ($category['news'] as $n) {
                if ($n['active']) {
                    $this->prepareNews($n, $category, $idParentCategories);
                }
            }
        }
        $idParentCategories []= $category['id'];
        foreach ($category['subcategories'] as $c) {
            $this->importCategory($c, $idParentCategories);
        }        
    }
        
    private  function prepareCategory($category) {
        $this->categoriesData []= [$category['id'], $category['name'], $category['active'] ];
    }
    
    private function prepareNews($news, $category, $idParentCategories) {
        $date = \DateTime::createFromFormat(self::DATE_FORMAT, $news['date']);
        $createdAt = $date->getTimestamp();
        
        if ($news['image'] !== '') {
            $hasImage = 1;
            $imageExtension = $this->getExtension($news['image']);
        } else {
            $hasImage = 0;
            $imageExtension = '';
        }

        $this->newsData []= [
            $news['id'],
            $news['title'],
            $news['description'],
            $news['text'],
            $news['active'],
            $createdAt,
            $hasImage,
            $imageExtension, 
        ];
        
        $this->categoryNewsData [] = [$news['id'], $category['id'] ];
        if ($this->manyToMany) {
            foreach ($idParentCategories as $idCategory) {
                $this->categoryNewsData [] = [$news['id'], $idCategory];
            }
        }
        if ($hasImage) {
            $filename = $news['id'].'.'.$imageExtension;
            $this->images [] = [
                'filename' => $filename,
                'url' => $news['image']
            ];
        }
    }
    
    private function insertCategories() {
        $db = Yii::$app->db;
        $db->createCommand()->batchInsert(
            Category::tableName(), 
            ['id', 'title', 'active'], 
            $this->categoriesData
        )->execute(); 
    }
    
    private function insertNews() {
        $db = Yii::$app->db;
        $db->createCommand()->batchInsert(
            News::tableName(), 
            ['id', 'title', 'description', 'text', 'active', 'createdAt', 'hasImage', 'imageExtension'], 
            $this->newsData
        )->execute(); 
    }
    
    private function insertCategoryNews() {
        $db = Yii::$app->db;
        $db->createCommand()->batchInsert(
            CategoryNews::tableName(), 
            ['idNews', 'idCategory'], 
            $this->categoryNewsData
        )->execute();  
    }
    
    private function uploadImages() {
        foreach($this->images as $image) {
            $file = file_get_contents($image['url']);
            $fullFilename = Yii::getAlias('@imagesNews').'/'.$image['filename'];
            file_put_contents($fullFilename, $file);            
        }
    }
    
    private function getExtension($str) {
        return substr($str, strrpos($str, '.') + 1);
    }
    
}