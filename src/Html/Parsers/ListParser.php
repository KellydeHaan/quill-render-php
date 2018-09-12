<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 07/09/2018
 * Time: 07:52
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Attribute;
use Oberon\Quill\Render\Html\Block\HtmlList;
use Oberon\Quill\Render\Html\Block\ListItem;
use Oberon\Quill\Render\Html\Block\MutableBlock;
use Oberon\Quill\Render\Html\Utils\HtmlTags;
use Oberon\Quill\Render\Interfaces\Parser;
use Oberon\Quill\Render\Interfaces\Renderer;

class ListParser implements Parser
{

    /**
     * @param array $op
     * @param Renderer[] $renderers
     * @return bool
     */
    public function handleOp(array $op, array &$renderers)
    {
        if (!$this->checkRequirements($op, $renderers)) {
            return false;
        }

        $paragraph = array_pop($renderers);
        if ($paragraph instanceof MutableBlock) {

            $listItem = new ListItem($paragraph->getChildren());

            $type = HtmlTags::toHtmlTag($op['attributes'][Attribute::LIST_ITEM], '');

            $prev = count($renderers) > 0 ? $renderers[count($renderers) - 1] : null;
            if ($prev !== null && $prev instanceof HtmlList && $prev->getType() === $type) {
                $prev->addChild($listItem);
            } else {
                try {
                    $list = new HtmlList($type);
                } catch (\Exception $e) {
                    return false;
                }
                $list->addChild($listItem);
                $renderers[] = $list;
            }

            return true;
        } else {
            return false;
        }
    }

    private function checkRequirements(array $op, array $renderables)
    {
        return
            count($renderables) > 0
            && array_key_exists('attributes', $op)
            && is_array($op['attributes'])
            && key_exists(Attribute::LIST_ITEM, $op['attributes'])
            && in_array(
                $op['attributes'][Attribute::LIST_ITEM],
                array(Attribute::LIST_ORDERED, Attribute::LIST_BULLET)
            );
    }

}