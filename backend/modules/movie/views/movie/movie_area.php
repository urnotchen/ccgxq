<?php
use yii\helpers\Html;
use backend\helper\MovieHelper;
/**
 * Created by PhpStorm.
 * User: chenxi
 * Date: 2017/8/2
 * Time: 18:29
 */

?>
<!--整个area-->
<div>
    <!--图片区域-->
    <div class="inline div_movie_poster float_left">
        <?php
            echo Html::a(Html::img($imageSrc,['class' => 'movie_poster']),$movieUrl,['target' => '_blank']);
        ?>
    </div>
    <!--文字区域-->
    <div class="inline float_left div_movie_poster" style="width:70%">
        <div class="force_new_line"><strong><?= $title?></strong></div>
        <div class="force_new_line">导演:<?= $director?></span></div>
        <div class="force_new_line"><?= $type?></span></div>
        <div class="force_new_line"><?= $releaseDate?></span></div>
        <?php

        ?>

    </div>
</div>
