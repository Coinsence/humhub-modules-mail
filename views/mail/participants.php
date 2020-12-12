<?php

use humhub\widgets\ModalDialog;
use humhub\modules\user\widgets\Image;

/* @var $message \humhub\modules\mail\models\Message */
?>


<?php ModalDialog::begin(['id' => 'modal-message-participants', 'header' => Yii::t("MailModule.views_mail_participants", "Participants")])?>

    <div class="modal-body">
        <?php foreach ($message->users as $user) : ?>
            <div class="participant">
                <?= Image::widget(['user' => $user, 'width' => '41'])?><strong><?= $user->getDisplayName() ?></strong>
            </div>
        <?php endforeach; ?>
    </div>

<?php ModalDialog::end() ?>
