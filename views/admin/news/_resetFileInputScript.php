<?php

\app\assets\ResetFileInputAsset::register($this);   

$this->registerJs(
    "
        $(document).ready(function() {
            var resetFileInput = new ResetFileInput(
                '$fileInputSelector',
                '$resetButtonSelector'
            );
        });
    ",
    \yii\web\View::POS_HEAD,
    'resetFileInput'
);