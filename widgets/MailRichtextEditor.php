<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\mail\widgets;


use humhub\modules\content\widgets\richtext\ProsemirrorRichTextEditor;
use Yii;

class MailRichtextEditor extends ProsemirrorRichTextEditor
{
    public function init()
    {
        $this->layout = static::LAYOUT_INLINE;
        $this->placeholder = Yii::t('MailModule.base', 'Write a message...');
        $this->menuClass = 'plainMenu';
        $this->pluginOptions = ['maxHeight' => '200px'];
        $this->exclude = [
            'code_block',
            'heading',
            'blockquote',
            'hard_break',
            'horizontal_rule',
            'mention',
            'table',
            'ordered_list',
            'fullscreen',
            'resizeNav',
        ];
        parent::init(); // TODO: Change the autogenerated stub
    }
}
