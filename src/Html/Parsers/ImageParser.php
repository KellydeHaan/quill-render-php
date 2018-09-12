<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 06/09/2018
 * Time: 17:41
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Html\Inline\CompoundImage;
use Oberon\Quill\Render\Html\Inline\Image;
use Oberon\Quill\Render\Html\Utils\InlineUtil;
use Oberon\Quill\Render\Interfaces\Parser;
use Oberon\Quill\Render\Interfaces\Renderer;

class ImageParser implements Parser
{

    /**
     * @param array $op
     * @param Renderer[] $renderers
     * @return bool
     */
    public function handleOp(array $op, array &$renderers)
    {
        if ($this->checkIsImage($op) === false) {
            return false;
        }

        //todo check if Image can be included in CompoundImage

        $image = null;
        if ($this->hasAttributes($op)) {
            $image = new CompoundImage($op['insert']['image']);
            foreach ($op['attributes'] as $attribute => $value) {
                $image->setAttribute($attribute, $value);
            }
        } else {
            $image = new Image($op['insert']['image']);
        }

        InlineUtil::addToParagraph($image, $renderers);

        return true;
    }

    private function checkIsImage(array $op)
    {
        return is_array($op['insert']) === true
            && array_key_exists('image', $op['insert']) === true;
    }

    private function hasAttributes($op)
    {
        return array_key_exists('attributes', $op) === true
            && is_array($op['attributes']) === true;
    }
}