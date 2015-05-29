<?php

namespace app\utils\formatters;
use yii\i18n\Formatter;

class NewsFormatter extends Formatter {

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
        return $this->asParagraphs($result);
    }
    
    public function asImageUrl($imageUrl) {
        if ($imageUrl === '') {
            return false;
        } else {
            return $this->asImage($imageUrl, ['style' => 'max-width : 600px']);
        }
    }
    
}

