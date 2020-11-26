<?php

/**
 * Shows a  preview of given $userMessage (UserMessage).
 * 
 * This can be the notification list or the message navigation
 */

use yii\helpers\Html;
use humhub\widgets\TimeAgo;
use humhub\libs\Helpers;
use yii\helpers\Url;
use humhub\widgets\Label;
use humhub\modules\mail\widgets\UsersImages as UsersImages;
use humhub\modules\mail\widgets\MessageTime;


/* @var $userMessage \humhub\modules\mail\models\UserMessage */
/* @var $active bool */

$message = $userMessage->message;
?>

<?php if ($message->getLastEntry() != null) : ?>
    <li data-message-preview="<?= $message->id ?>" class="messagePreviewEntry entry <?= $active ? 'selected' : ''?>">
        <a href="#" class="mail-link" data-action-click="mail.wall.loadMessage" data-action-url="<?= Url::to(['/mail/mail', 'id' => $message->id])?>" data-message-id="<?= $message->id ?>">
            <div class="media">
                <div class="media-left pull-left">
                    <?= UsersImages::widget(['type' => 'panel', 'users' => $message->users]) ?>
                </div>

                <div class="media-body text-break">
                    <?php if (count($message->users) == 2) : ?>
                    <div class="media-heading">
                        <h4 class="text"><?= Html::encode($message->users[1]->getDisplayName()); ?><span class="sep">|</span><?= Html::encode(Helpers::truncateText($message->title, 32)); ?></h4>
                        <?= MessageTime::widget(['timestamp' => $message->updated_at]); ?>
                    </div>
                    <?php else : ?>
                    <div class="media-heading">
                        <h4 class="text"><?= Html::encode(Helpers::truncateText($message->title, 75)); ?></h4>
                        <?= MessageTime::widget(['timestamp' => $message->updated_at]); ?>
                    </div>
                    <?php endif; ?>
                    <small class="pull-right"></small>

                    <p><?= Html::encode($message->getPreview()) ?></p>

                    <?= Label::danger(Yii::t('MailModule.views_mail_index', 'New'))
                        ->cssClass('new-message-badge')->style((!$userMessage->isUnread() ? 'display:none' : '')); ?>
                </div>
            </div>
        </a>
    </li>
<?php endif; ?>
