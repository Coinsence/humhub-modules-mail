<?php

use humhub\modules\user\widgets\Image;
use humhub\widgets\Button;
use humhub\widgets\ModalButton;
use humhub\modules\content\widgets\richtext\RichText;
use humhub\modules\mail\widgets\MessageEntryTime;
use humhub\libs\Html;

/* @var $entry \humhub\modules\mail\models\MessageEntry */
/* @var $options array */
/* @var $who string */

?>

<?= Html::beginTag('div', $options) ?>

<div class="media <?= $who ?>">

    <?php if ($who !== 'me'): ?>
        <span class="pull-left user-image">
            <?= Image::widget(['user' => $entry->user, 'width' => 29]) ?>
        </span>
    <?php else: ?>
        <ul class="nav nav-pills preferences">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"
                   aria-label="<?= Yii::t('base', 'Toggle message entry menu'); ?>" aria-haspopup="true">
                    <i class="fa fa-ellipsis-v"></i>
                </a>

                <ul class="dropdown-menu pull-right">
                    <li>
                        <?= ModalButton::asLink(Yii::t('base', 'Edit'))->icon('fa-pencil-square-o')->load( ["/mail/mail/edit-entry", 'id' => $entry->id]) ?>
                    </li>
                    <li>
                        <?= Button::asLink(Yii::t('base', 'Delete'))->icon('fa-trash-o')->options(['data-entry-id' => $entry->id])
                            ->action('mail.wall.deleteEntry')
                            ->confirm(Yii::t('MailModule.views_mail_show', '<strong>Confirm</strong> message deletion'),
                                Yii::t('MailModule.views_mail_show', 'Do you really want to delete this message?'),
                                Yii::t('MailModule.views_mail_show', 'Delete'),
                                Yii::t('MailModule.views_mail_show', 'Cancel')) ?>
                    </li>
                </ul>
            </li>
        </ul>
    <?php endif; ?>

    <div class="media-body <?= $who === 'me' ? 'pull-right' : 'pull-left' ?>">
        <?php if ($who !== 'me'): ?>
            <h6 class="media-heading">
                <?= Html::encode($entry->user->displayName); ?>
            </h6>
        <?php endif; ?>
        <span class="content">
            <?= RichText::output($entry->content); ?>
            <small class="time-container"><?= MessageEntryTime::widget(['timestamp' => $entry->created_at]); ?></small>
        </span>
    </div>

</div>

<?= Html::endTag('div') ?>


