<?php

namespace humhub\modules\mail\widgets;

use Yii;
use humhub\components\Widget;
use yii\db\Expression;

/**
 * Shows a given date & time as automatically updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago").
 *
 * @author luke
 */
class MessageEntryTime extends Widget
{

    /**
     * @var string Database (Y-m-d H:i:s) or Unix timestamp
     */
    public $timestamp;

    /**
     * @var string Type of the rendered time ('entry', 'divider')
     */
    public $type;

    /**
     * @var bool whether to return with html tags or not
     */
    public $raw = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Make sure we get an timestamp in server tz
        if (is_numeric($this->timestamp)) {
            $this->timestamp = date('Y-m-d H:i:s', $this->timestamp);
        } elseif ($this->timestamp instanceof Expression && $this->timestamp->expression === 'NOW()') {
            $this->timestamp = date('Y-m-d H:i:s');
        }
        $this->timestamp = strtotime($this->timestamp);

        if (!$this->type || !in_array($this->type, array('entry', 'divider'))) {
            $this->type = 'entry';
        }

        if (!$this->raw) {
            $this->raw = false;
        } else {
            $this->raw = true;
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->type === 'entry') {
            return $this->renderTimeOnly();
        } else {
            $now = time();
            $now = $now - ($now % 86400);
            $elapsed = $now - $this->timestamp;

            $elapsedDays = $elapsed/(60*60*24);
            $elapsedDays = ceil($elapsedDays);

            if ($elapsedDays == 0) {
                return $this->renderToday();
            }
            elseif ($elapsedDays < 7) { // in the past week
                return $this->renderDayNameOnly();
            } else { // before the past week
                return $this->renderDate();
            }
        }

    }

    /**
     * renders today time only
     *
     * @return string
     */
    public function renderTimeOnly() {
        $date = Yii::$app->formatter->asDate($this->timestamp, 'php:H:i');

        if ($this->raw) {
            return $date;
        } else {
            return '<span class="time"><span title="' . $this->timestamp . '">' . $date . '</span></span>';
        }
    }

    /**
     * renders today string
     *
     * @return string
     */
    public function renderToday() {
        $date = Yii::t('MailModule.base', 'Today');

        if ($this->raw) {
            return $date;
        } else {
            return '<span class="time"><span title="' . $this->timestamp . '">' . $date . '</span></span>';
        }
    }

    /**
     * returns day name only
     *
     * @return string
     */
    public function renderDayNameOnly() {
        $date = Yii::$app->formatter->asDate($this->timestamp, 'php:l');

        if ($this->raw) {
            return $date;
        } else {
            return '<span class="time"><span title="' . $this->timestamp . '">' . $date . '</span></span>';
        }
    }

    /**
     * returns simple date
     *
     * @return string
     */
    public function renderDate() {
        $date = Yii::$app->formatter->asDate($this->timestamp, 'php:M d, Y');

        if ($this->raw) {
            return $date;
        } else {
            return '<span class="time"><span title="' . $this->timestamp . '">' . $date . '</span></span>';
        }
    }
}