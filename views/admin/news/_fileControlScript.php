<?php

\app\assets\FileControlAsset::register($this);

$fileControlId = 'fileControl';
$this->registerJs(
    "
        $(document).ready(function() {
            var fileControl = new FileControl('$fileControlId');
        });
    ",
    \yii\web\View::POS_HEAD,
    'fileControl'
);
