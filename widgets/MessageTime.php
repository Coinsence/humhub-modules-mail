<?php

namespace humhub\modules\mail\widgets;

use Yii;
use humhub\components\Widget;

/**
 * Shows a given date & time as automatically updating fuzzy timestamps (e.g. "4 minutes ago" or "about 1 day ago").
 *
 * @author luke
 */
class MessageTime extends Widget
{

    /**
     * @var string Database (Y-m-d H:i:s) or Unix timestamp
     */
    public $timestamp;

    /**
     * @inheritdoc
     */
    public function init()
    {
        // Make sure we get an timestamp in server tz
        if (is_numeric($this->timestamp)) {
            $this->timestamp = date('Y-m-d H:i:s', $this->timestamp);
        }
        $this->timestamp = strtotime($this->timestamp);
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $now = time();
        $now = $now - ($now % 86400);
        $elapsed = $now - $this->timestamp;

        $elapsedDays = $elapsed/(60*60*24);
        $elapsedDays = ceil($elapsedDays);

        if ($elapsedDays == 0) { // today
            return $this->renderTimeOnly();
        } elseif ($elapsedDays < 7) { // in the past week
            return $this->renderDayNameOnly();
        } else { // before the past week
            return $this->renderDate();
        }
    }

    /**
     * renders today time only
     *
     * @return string
     */
    public function renderTimeOnly() {
        return '<span class="time"><span title="' . $this->timestamp . '">' . Date('H:i', $this->timestamp) . '</span></span>';
    }

    /**
     * returns day name only
     *
     * @return string
     */
    public function renderDayNameOnly() {
        return '<span class="time"><span title="' . $this->timestamp . '">' . Date('l', $this->timestamp) . '</span></span>';
    }

    /**
     * returns simple date
     *
     * @return string
     */
    public function renderDate() {
        return '<span class="time"><span title="' . $this->timestamp . '">' . Date('M d, Y', $this->timestamp) . '</span></span>';
    }
}