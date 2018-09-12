<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 12/09/2018
 * Time: 12:10
 */

namespace Oberon\Quill\Render\Html;

use Oberon\Quill\Render\RenderQuill;

/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 12/09/2018
 * Time: 12:05
 */
class HtmlParser
{

    public static function withQuill($quillJson)
    {
        $quill = new RenderQuill();
        $quill->setParsers(DefaultHtmlParsers::get());
        $quill->load($quillJson);

        return $quill;
    }

}