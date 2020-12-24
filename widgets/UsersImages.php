<?php

namespace humhub\modules\mail\widgets;

use Yii;
use humhub\components\Widget;

/**
 * @package humhub.modules.mail
 * @since 0.5
 */
class UsersImages extends Widget
{

    const MAX_VISIBLE_USERS_IN_HEADER = 3;
    const MAX_VISIBLE_USERS_IN_PANEL = 4;
    const PANEL_ONE_IMAGE_WIDTH = 59;
    const PANEL_ONE_IMAGE_CSS_CLASS = 'img-num-1';
    const PANEL_TWO_IMAGES_WIDTH = 42;
    const PANEL_TWO_IMAGES_CSS_CLASS = 'img-num-2';
    const PANEL_THREE_IMAGES_WIDTH = 36;
    const PANEL_THREE_IMAGES_CSS_CLASS = 'img-num-3';
    const PANEL_MORE_IMAGES_WIDTH = 34;
    const PANEL_MORE_IMAGES_CSS_CLASS = 'img-num-4-or-more';

    /**
     * @var array array of message users
     */
    public $users;

    /**
     * @var int id of the message
     */
    public $messageId;

    /**
     * @var string Users images type: 'header' or 'panel'
     */
    public $type;

    /**
     * @var bool if user message is read or not
     */
    public $isUnread;

    /**
     * @var int number of excessive users
     */
    private $excessiveUsersNumber;

    /**
     * @var string class to be used in relation with imageWidth
     */
    private $cssClass;

    /**
     * @var int width of the user image to be generated
     */
    private $imageWidth;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $currentUser = Yii::$app->user->id;

        // remove current user from the users array
        $this->users = array_filter($this->users, function ($user) use ($currentUser) {
            return $user->id != $currentUser;
        });

        if ($this->type == 'header') { // HEADER (conversation panel header)
            if (sizeof($this->users) > self::MAX_VISIBLE_USERS_IN_HEADER) {
                $randomCount = self::MAX_VISIBLE_USERS_IN_HEADER - 1;
            }
        } else if($this->type == 'panel') { // PANEL (conversation chooser panel)
            if (count($this->users) > self::MAX_VISIBLE_USERS_IN_PANEL) {
                $randomCount = self::MAX_VISIBLE_USERS_IN_PANEL - 1;
            }
        }

        $this->excessiveUsersNumber = count($this->users);

        if (isset($randomCount) && $randomCount > 0) {
            if ($randomCount > 1) {
                $randomKeys = array_rand($this->users, $randomCount);
            } else {
                $randomKeys[] = array_rand($this->users, $randomCount);
            }
            $randomUsers = [];
            foreach ($randomKeys as $key) {
                $randomUsers[] = $this->users[$key];
            }
            $this->users = $randomUsers;
        }

        $this->excessiveUsersNumber -= count($this->users);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->type == 'header') {
            return $this->render('usersImages_Header', [
                'users' => $this->users,
                'excessiveUsersNum' => $this->excessiveUsersNumber,
                'messageId' => $this->messageId
            ]);
        }
        if ($this->type == 'panel') {
            $count = count($this->users);
            if ($this->excessiveUsersNumber && $this->excessiveUsersNumber > 0) {
                $count += 1;
            }
            switch ($count) {
                case 0:
                    return;
                case 1:
                    $this->cssClass = self::PANEL_ONE_IMAGE_CSS_CLASS;
                    $this->imageWidth = self::PANEL_ONE_IMAGE_WIDTH;
                    break;
                case 2:
                    $this->cssClass = self::PANEL_TWO_IMAGES_CSS_CLASS;
                    $this->imageWidth = self::PANEL_TWO_IMAGES_WIDTH;
                    break;
                case 3:
                    $this->cssClass = self::PANEL_THREE_IMAGES_CSS_CLASS;
                    $this->imageWidth = self::PANEL_THREE_IMAGES_WIDTH;
                    break;
                default:
                    $this->cssClass = self::PANEL_MORE_IMAGES_CSS_CLASS;
                    $this->imageWidth = self::PANEL_MORE_IMAGES_WIDTH;
                    break;
            }

            return $this->render('usersImages_Panel', [
                'users' => $this->users,
                'isUnread' => $this->isUnread,
                'excessiveUsersNum' => $this->excessiveUsersNumber,
                'cssClass' => $this->cssClass,
                'imageWidth' => $this->imageWidth
            ]);
        }
    }

}

?>