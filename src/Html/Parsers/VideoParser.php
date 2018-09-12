<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 07/09/2018
 * Time: 07:52
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Html\Inline\Video;
use Oberon\Quill\Render\Html\Utils\InlineUtil;
use Oberon\Quill\Render\Interfaces\Parser;
use Oberon\Quill\Render\Interfaces\Renderer;

class VideoParser implements Parser
{

    /**
     * @param array $op
     * @param Renderer[] $renderers
     * @return bool
     */
    public function handleOp(array $op, array &$renderers)
    {
        if (!$this->checkIsVideo($op)) {
            return false;
        }

        $video = new Video($op['insert']['video']);
        InlineUtil::addToParagraph($video, $renderers);

        return true;
    }

    private function checkIsVideo(array $op)
    {
        return is_array($op['insert']) === true
            && array_key_exists('video', $op['insert']) === true;
    }
}