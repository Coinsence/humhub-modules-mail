<?php

use humhub\modules\mail\permissions\StartConversation;
use humhub\modules\mail\widgets\NewMessageButton;
use yii\widgets\LinkPager;

/* @var $userMessages \humhub\modules\mail\models\UserMessage[] */
/* @var $pagination \yii\data\Pagination */
/* @var $activeMessageId int */

$canStartConversation = Yii::$app->user->can(StartConversation::class);

?>

<div id="mail-conversation-overview" class="panel panel-default">
    <div class="panel-heading">
        <span><?= Yii::t('MailModule.views_mail_index', 'Conversations') ?></span>
        <?php if($canStartConversation) : ?>
            <?= NewMessageButton::widget(['icon' => 'fa-plus', 'size' => 'xs', 'iconOnly' => true])?>
        <?php endif; ?>
    </div>

    <hr>

    <ul id="inbox" class="media-list">
        <?php if (empty($userMessages)) : ?>
            <li class="placeholder"><?= Yii::t('MailModule.views_mail_index', 'There are no messages yet.'); ?></li>
        <?php else: ?>
            <?php foreach ($userMessages as $userMessage) : ?>
                <?= $this->render('_messagePreview', ['userMessage' => $userMessage, 'active' => ($userMessage->message_id == $activeMessageId)]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

<div class="pagination-container">
    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>
