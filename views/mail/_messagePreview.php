<?php

/**
 * Shows a  preview of given $userMessage (UserMessage).
 * 
 * This can be the notification list or the message navigation
 */

use yii\helpers\Html;
use humhub\libs\Helpers;
use yii\helpers\Url;
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
                    <?= UsersImages::widget(['type' => 'panel', 'users' => $message->users, 'isUnread' => $userMessage->isUnread()]) ?>
                </div>

                <div class="media-body text-break">
                    <div class="media-heading">
                        <?php if (count($message->users) == 2) : ?>
                        <h4 class="text"><?= Html::encode(Helpers::truncateText($message->users[1]->getDisplayName(), 10)); ?><span class="sep">|</span><?= Html::encode(Helpers::truncateText($message->title, 10)); ?></h4>
                        <?php else : ?>
                        <h4 class="text"><?= Html::encode(Helpers::truncateText($message->title, 25)); ?></h4>
                        <?php endif; ?>
                        <?= MessageTime::widget(['timestamp' => $message->updated_at]); ?>
                    </div>
                    <p><?= Html::encode(Helpers::truncateText($message->getPreview(), 56))  ?></p>

                </div>
            </div>
        </a>
    </li>
<?php endif; ?>
