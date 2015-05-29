<?php

namespace app\services;

// Используется в качестве возвращаемого значения в create/update методах.
// Т.к. в результате их работы в случее непрохождения валидации изменений 
// в базе данных не будет, но ошибки валидации можно отобразить
// пользователю. 
// Т.е. в случае ошибки $isSuccess === false, а в модели будет установлены 
// ошибки валидации. В случае удачного создания $isSuccess === true.
class SaveResult extends \yii\base\Object {
    
    protected $_model;
    protected $_isSuccess;
    
    public function __construct($model, $isSuccess = false) {
        parent::__construct();
        $this->_model = $model;
        $this->_isSuccess = $isSuccess;
    }
    
    public function getIsSuccess() {
        return $this->_isSuccess;
    }
    
    public function getModel() {
        return $this->_model;
    }

}
