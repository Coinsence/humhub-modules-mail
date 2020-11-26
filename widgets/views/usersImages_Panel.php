<?php

use humhub\modules\user\widgets\Image;


/* @var $users array */
/* @var $excessiveUsersNum int */
/* @var $cssClass string */
/* @var $imageWidth int */

?>
<div class="panel_users-images <?= $cssClass ?>">
    <?php foreach ($users as $user) : ?>
        <?= Image::widget(['user' => $user, 'width' => $imageWidth, 'link' => false])?>
    <?php endforeach; ?>
    <?php if ($excessiveUsersNum > 0) : ?>
        <!-- TODO: tooltip with all the excessive users names-->
        <button class="btn-xs btn btn-info"><?= '+' . $excessiveUsersNum ?></button>
    <?php endif; ?>
</div>
