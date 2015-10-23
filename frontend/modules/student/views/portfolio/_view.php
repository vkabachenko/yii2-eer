<?php

/**
 * @var yii\web\View            $this
 * @var kartik\tree\models\Tree $node
 */

use yii\helpers\Html;
use himiklab\thumbnail\EasyThumbnailImage;

extract($params);

?>

<h2>
    <?= $node->name ?>
</h2>

<?php

if ($node->filename) {

    $img = EasyThumbnailImage::thumbnailImg(
        Yii::getAlias('@frontend/web/files').'/'.$node->filename,
        200,
        200,
        EasyThumbnailImage::THUMBNAIL_INSET,
        ['alt' => $node->document]
    );

    /* Если это не картинка, распознаваемая imagine, то в папке thumbs
    ищем иконку, имя которой совпадает с расширением файла документа.
    Если такой иконки нет, подставляем пустую иконку */

    if (strpos($img,'Error') !== false) {

        $thumbName = pathinfo($node->filename, PATHINFO_EXTENSION);
        $thumbDb =  Yii::getAlias('@frontend/web/thumbs').'/';
        $files = glob($thumbDb.$thumbName.'.*');
        $icon = count($files) == 0 ? '_page.png' : basename($files[0]);
        $icon = '@web/thumbs/'.$icon;
        $img = Html::img($icon,['alt' => $node->document]);

    }


    echo Html::tag('p',Html::a($img,[
       '/student/portfolio/download',
       'id' => $node->id,
       'modelFile' => '\common\models\StudentPortfolio'
    ]));

}

?>
