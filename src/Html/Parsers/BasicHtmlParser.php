<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 06/09/2018
 * Time: 16:00
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Attribute;
use Oberon\Quill\Render\Html\Inline\Tag;
use Oberon\Quill\Render\Html\Utils\HtmlTags;
use Oberon\Quill\Render\Html\Utils\InlineUtil;
use Oberon\Quill\Render\Interfaces\Parser;

class BasicHtmlParser implements Parser
{

    const SUPPORTED_ATTRS = [
        Attribute::BOLD,
        Attribute::ITALIC,
        Attribute::LINK,
        Attribute::SCRIPT,
        Attribute::STRIKE,
        Attribute::UNDERLINE,
    ];

    public function handleOp(array $op, array &$renderers)
    {
        if ($this->checkRequirements($op) === false) {
            return false;
        }

        $tags = [];
        $attrs = [];
        foreach ($op['attributes'] as $attribute => $value) {
            if (in_array($attribute, self::SUPPORTED_ATTRS)) {
                $tags[] = HtmlTags::toHtmlTag($attribute, $value);
            } else {
                $attrs[$attribute] = $value;
            }
        }

        $child = new Tag($tags, $attrs, $op['insert']);
        InlineUtil::addToParagraph($child, $renderers);

        return true;
    }

    private function checkRequirements($op)
    {
        return
            array_key_exists('attributes', $op)
            && is_array($op['attributes'])
            && is_string($op['insert']);
    }
}