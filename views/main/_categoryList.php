<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\assets\CategoryListAsset;

CategoryListAsset::register($this);
?>
<?php if (count($categories) > 0 ) : ?>
    <div class="categoryList">
    <?php foreach ($categories as $c) : ?>
        <?php
            // Выделяем выбранную категорию.
            if ( ($currentCategory !== null) && (intval($currentCategory) === $c->id)  ) {
                $itemCssClass = '-darkRed -darkRed--constant';
            } else {
                $itemCssClass = '-orange -orange--action'; 
            }

            $url = Url::to(['main/index', 'category' => $c->id]);
        ?>
        <a class="categoryListItem  <?=$itemCssClass?>" href="<?=$url?>">
            <div class="categoryListItem__title">
                <?= Html::encode($c->title) ?>
            </div>
            <div class="categoryListItem__description">
                <?= nl2br(Html::encode($c->description) ) ?>
            </div>
        </a>
    <?php endforeach; ?>
    </div>
<?php endif; ?>