<?php
use humhub\libs\Html;

use yii\helpers\Url;
use humhub\widgets\Button;
use humhub\modules\mail\widgets\UsersImages as UsersImages;

/* @var $message \humhub\modules\mail\models\Message */
?>

<div class="left">
    <?= UsersImages::widget(['type' => 'header', 'users' => $message->users, 'messageId' => $message->id]) ?>
    <?php if (count($message->users) == 2) : ?>
        <span class="conversation-title"><?= Html::encode($message->users[1]->getDisplayName()); ?></span>
    <?php else : ?>
        <span class="conversation-title"><?= Html::encode($message->title); ?></span>
    <?php endif; ?>
</div>

<div class="conversation-actions">
    <?php if (count($message->users)) : ?>
        <?php if (count($message->users) != 1) : ?>
            <?= Button::asLink('<span>' . Yii::t('MailModule.views_mail_show', 'Leave conversation') . '</span>')
                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->lg()
                ->confirm( Yii::t('MailModule.views_mail_show', '<strong>Confirm</strong> leaving conversation'),
                    Yii::t('MailModule.views_mail_show', 'Do you really want to leave this conversation?'),
                    Yii::t('MailModule.views_mail_show', 'Leave'))?>
        <?php elseif (count($message->users) == 1) : ?>
            <?= Button::primary( )
                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->sm()
                ->confirm( Yii::t('MailModule.views_mail_show', '<strong>Confirm</strong> deleting conversation'),
                    Yii::t('MailModule.views_mail_show', 'Do you really want to delete this conversation?'),
                    Yii::t('MailModule.views_mail_show', 'Delete'))->tooltip(Yii::t('MailModule.views_mail_show', 'Delete conversation'))?>
            ?>
        <?php endif; ?>

    <?php endif; ?>
</div>
