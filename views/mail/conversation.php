<?php

use humhub\libs\Html;
use humhub\modules\mail\permissions\StartConversation;
use yii\bootstrap\ActiveForm;
use humhub\modules\mail\widgets\MessageEntryTime;
use humhub\modules\mail\widgets\MailRichtextEditor;
use humhub\modules\mail\widgets\wall\ConversationEntry;
use humhub\widgets\Button;

$canStartConversation = Yii::$app->user->can(StartConversation::class);

/* @var $this \humhub\modules\ui\view\components\View */
/* @var $replyForm \humhub\modules\mail\models\forms\ReplyForm */
/* @var $messageCount integer */


?>
<div class="panel panel-default">

    <?php if ($message == null) : ?>

        <div class="panel-body">
            <?= Yii::t('MailModule.views_mail_show', 'There are no messages yet.'); ?>
        </div>

    <?php  else :?>

        <div id="mail-conversation-header" class="panel-heading">
            <?= $this->render('_conversation_header', ['message' => $message]) ?>
        </div>

        <hr>

        <div class="panel-body">

            <div class="media-list conversation-entry-list">
                <?php $day = '' ?>
                <?php foreach ($message->entries as $entry) : ?>
                    <?php $newDay = MessageEntryTime::widget(['timestamp' => $entry->created_at, 'type' => 'divider', 'raw' => true]) ?>
                    <?php if ($newDay !== $day) : ?>
                        <?php $day = $newDay; ?>
                        <?= $this->render('_date_divider', ['day' => $day]) ?>
                    <?php endif; ?>
                    <?= ConversationEntry::widget(['entry' => $entry])?>
                <?php endforeach; ?>
            </div>


            <div class="mail-message-form row-fluid">
                <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>

                    <?= $form->field($replyForm, 'message')->widget(
                        MailRichtextEditor::class)->label(false); ?>

                    <?= Button::asLink()->cssClass('reply-button')->submit()->action('reply', $replyForm->getUrl())->right()->icon('fa-paper-plane')->lg() ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>

    <?= Html::beginTag('script')?>
        humhub.modules.mail.setMailMessageCount(<?= $messageCount ?>);
    <?= Html::endTag('script')?>
</div>
