<?php

namespace app\services\category;

use app\models\Category;

class CategoryService {

    public function __construct() {
    
    }
    
    public function getById($id) {
        return Category::findOne($id);
    }
    
    public function getByActive($active = null) {
        $query = Category::find();
        if ($active !== null) {
            $query->where(['active' => $active]);
        }
        return $query->all();
    }
    
    public function create($model, $attributes) {
        $model->setAttributes($attributes);
        if (!$model->save() ) {
            return false;    
        }
        return true;
    }
    
    public function update($model, $attributes) {
        $model->setAttributes($attributes);
        if (!$model->save() ) {
            return false;    
        }
        return true;
    }
    
    public function delete($model) {
        $model->delete();
    }
        
}