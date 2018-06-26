<?php
namespace backend\votewidget;

use yii\base\Widget;

class VoteWidget extends Widget
{
    public function init()
    {
        parent::init();
        ob_start();
    }

    public function run()
    {
        $content = ob_get_clean();
        $fontawesome_url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css';
        $this->getView()->registerCssFile($fontawesome_url, [], 'VoteWidget-fontawesome');
        return $content;
    }
}
?>