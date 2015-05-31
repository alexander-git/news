<?php

namespace app\services\news;

use Yii;
use app\models\News;

class NewsService {

    public function __construct() {
    
    }
    
    public function getWithCategoryListById($id) {
        return News::find()->joinWith([
                'categories' => function ($query) {
                    $query->select(['id', 'title']);
                }
            ])->where([News::tableName().'.id' => $id])->one();
    }
    
    public function create($model, $attributes, $idCategories = null) {
        try {
            $this->save($model, $attributes, $idCategories);
            return true;
        }
        catch(\Exception $e) {
            return false;
        }   
    }
    
    public function update($model, $attributes, $needDeleteOldImageIfExist = false, $idCategories = null) {
        try {
            if ($needDeleteOldImageIfExist) {
                $model->hasImage = false;
            }
            $this->save($model, $attributes, $idCategories);
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }
    
    public function delete($model) {
        $t = Yii::$app->db->beginTransaction();
        try {
            $model->deleteCategories();
            $model->delete();
            $t->commit();
        }
        catch(\Exception $e) {
            $t->rollback();
            throw $e;
        }
    }
    
     private function save($model, $attributes, $idCategories = null) {
        $t = Yii::$app->db->beginTransaction();
        try {
            $model->setAttributes($attributes);
            if (!$model->save() ) {
                throw new \yii\base\Exception(); //TODO#
            }
            if ($idCategories === null) {
                $model->deleteCategories();
            } else {
                $model->setCategories($idCategories);
            }
            $t->commit(); 
        } 
        catch(\Exception $e) {
            $t->rollback();
            throw $e;
        }    
    }
    
}