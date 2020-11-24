<?php

namespace humhub\modules\mail\widgets;

use Yii;
use humhub\components\Widget;
use function foo\func;

/**
 * @package humhub.modules.mail
 * @since 0.5
 */
class UsersImages extends Widget
{

    const MAX_VISIBLE_USERS_IN_HEADER = 3;
    const MAX_VISIBLE_USERS_IN_PANEL = 4;

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
     * @var int number of excessive users
     */
    private $excessiveUsersNumber;

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

        if (isset($randomCount)) {
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
            return $this->render('usersImages_Panel', [
            ]);
        }

    }

}

?>