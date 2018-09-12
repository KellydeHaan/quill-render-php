<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 12/09/2018
 * Time: 11:08
 */

namespace Oberon\Quill\Render\Html;

use Oberon\Quill\Render\Html\Parsers\BasicHtmlParser;
use Oberon\Quill\Render\Html\Parsers\HeaderParser;
use Oberon\Quill\Render\Html\Parsers\ImageParser;
use Oberon\Quill\Render\Html\Parsers\LinkParser;
use Oberon\Quill\Render\Html\Parsers\ListParser;
use Oberon\Quill\Render\Html\Parsers\TextParser;
use Oberon\Quill\Render\Html\Parsers\VideoParser;

class DefaultHtmlParsers
{

    public static function get()
    {
        return [
            new VideoParser(),
            new ImageParser(),
            new ListParser(),
            new TextParser(),
            new HeaderParser(),
            new LinkParser(),
            new BasicHtmlParser(),
        ];
    }
}