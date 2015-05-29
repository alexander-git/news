<?php

\app\assets\FileControlAsset::register($this);

$fileControlId = 'fileControl';
$this->registerJs(
    "
        $(document).ready(function() {
            var FileControl = new FileControl('$fileControlId');
        });
    ",
    \yii\web\View::POS_HEAD,
    'fileControl'
);
