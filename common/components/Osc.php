<?php
namespace common\components;


use yii\helpers\Html;

class Osc {


    /**
     * [generate_slug description]
     * @param  [type] $text [description]
     * @return [type]       [description]
     */
    public function generate_slug($text){
        // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
      $text = trim($text, '-');

  // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

  // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

}
?>