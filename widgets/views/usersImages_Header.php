<?php

use humhub\modules\mail\permissions\StartConversation;
use humhub\widgets\ModalButton;
use humhub\modules\user\widgets\Image;


/* @var $users array */
/* @var $excessiveUsersNum int */
/* @var $messageId int */


$canStartConversation = Yii::$app->user->can(StartConversation::class);

?>

<div class="header_users-images">
    <div class="users-images">
        <?php if ($excessiveUsersNum > 0) : ?>
            <!-- TODO: tooltip with all the excessive users names-->
            <button class="btn-xs btn btn-info"><?= '+' . $excessiveUsersNum ?></button>
        <?php endif; ?>
        <?php foreach ($users as $user) : ?>
            <?= Image::widget(['user' => $user, 'width' => '41', 'showTooltip' => true])?>
        <?php endforeach; ?>

        <!-- Button to trigger modal to add user to conversation -->
        <?= ModalButton::info()->icon('fa-plus')->xs()
            ->load(['/mail/mail/add-user', 'id' => $messageId])->visible($canStartConversation) ?>
    </div>
</div>
