<?php

namespace app\utils\formatters;
use yii\i18n\Formatter;

class NewsFormatter extends Formatter {

    public $datetimeFormat = 'j-MM-Y H:i:s';
    public $booleanFormat = ['Нет', 'Да'];
    public $nullDisplay = '';
    
    public function __construct() {
        parent::__construct();
    }

    public function asCategories($categories) {
        $result = '';
        foreach ($categories as $c) {
            $result .= $c->title."\n\n";
        }
        return parent::asParagraphs($result);
    }
    
    public function asImage($value, $options = []) {
        if ($value === '') {
            return false;
        } else {
            if (count($options) === 0) {
                return parent::asImage($value, ['style' => 'max-width : 600px; max-height : 600px;']);  
            } else {
                return parent::asImage($value, $options);
            }
            
        }
    }
    
}

