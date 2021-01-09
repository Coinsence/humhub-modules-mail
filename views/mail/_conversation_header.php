<?php

use humhub\libs\Html;
use humhub\modules\mail\permissions\StartConversation;
use yii\helpers\Url;
use humhub\widgets\Button;
use humhub\modules\mail\widgets\UsersImages as UsersImages;
use humhub\widgets\ModalButton;
use humhub\libs\Helpers;

$canStartConversation = Yii::$app->user->can(StartConversation::class);

/* @var $message \humhub\modules\mail\models\Message */

?>

<div class="left">
    <ul class="nav preferences">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"
               aria-label="<?= Yii::t('base', 'Toggle message entry menu'); ?>" aria-haspopup="true">
                <i class="fa fa-ellipsis-v"></i>
            </a>
            <ul class="dropdown-menu pull-left">
                <li>
                    <?= ModalButton::asLink('<span>' . Yii::t('MailModule.views_mail_show', 'Add users to conversation') . '</span>')
                        ->load(['/mail/mail/add-user', 'id' => $message->id])->visible($canStartConversation) ?>
                </li>
                <li>
                    <?= ModalButton::asLink('<span>' . Yii::t('MailModule.views_mail_participants', 'Show participants') . '</span>')
                        ->load(['/mail/mail/participants', 'id' => $message->id])->visible($canStartConversation) ?>
                </li>
                <li>
                    <?php if (count($message->users)) : ?>
                        <?php if (count($message->users) != 1) : ?>
                            <?= Button::asLink('<span>' . Yii::t('MailModule.views_mail_show', 'Leave conversation') . '</span>')
                                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->sm()
                                ->confirm( Yii::t('MailModule.views_mail_show', '<strong>Confirm</strong> leaving conversation'),
                                    Yii::t('MailModule.views_mail_show', 'Do you really want to leave this conversation?'),
                                    Yii::t('MailModule.views_mail_show', 'Leave'))?>
                        <?php elseif (count($message->users) == 1) : ?>
                            <?= Button::asLink('<span>' . Yii::t('MailModule.views_mail_show', 'Delete conversation') . '</span>')
                                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->sm()
                                ->confirm( Yii::t('MailModule.views_mail_show', '<strong>Confirm</strong> deleting conversation'),
                                    Yii::t('MailModule.views_mail_show', 'Do you really want to delete this conversation?'),
                                    Yii::t('MailModule.views_mail_show', 'Delete'))->tooltip(Yii::t('MailModule.views_mail_show', 'Delete conversation'))?>
                            ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            </ul>
        </li>
    </ul>
    <?= UsersImages::widget(['type' => 'header', 'users' => $message->users, 'messageId' => $message->id]) ?>
    <?php if (count($message->users) == 2) : ?>
        <span class="conversation-title"><?= Html::encode(Helpers::truncateText($message->getRecepients()[0]->getDisplayName(), 25)); ?></span>
    <?php else : ?>
        <span class="conversation-title"><?= Html::encode(Helpers::truncateText($message->title, 25)); ?></span>
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
            <?= Button::asLink('<span>' . Yii::t('MailModule.views_mail_show', 'Delete conversation') . '</span>')
                ->action('mail.wall.leave', Url::to(["/mail/mail/leave", 'id' => $message->id]))->icon('fa-sign-out')->lg()
                ->confirm( Yii::t('MailModule.views_mail_show', '<strong>Confirm</strong> deleting conversation'),
                    Yii::t('MailModule.views_mail_show', 'Do you really want to delete this conversation?'),
                    Yii::t('MailModule.views_mail_show', 'Delete'))->tooltip(Yii::t('MailModule.views_mail_show', 'Delete conversation'))?>
            ?>
        <?php endif; ?>

    <?php endif; ?>
</div>
<a href="#" class="close-discussion" data-action-click="mail.wall.toggleDiscussion">
    <i class="fa fa-close"></i>
</a>
