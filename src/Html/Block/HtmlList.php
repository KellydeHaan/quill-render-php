<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 11/09/2018
 * Time: 15:25
 */

namespace Oberon\Quill\Render\Html\Block;

use Oberon\Quill\Render\Html\Utils\HtmlTags;

/**
 * Class HtmlList
 * @package Oberon\Quill\Render\Html\Block
 */
class HtmlList extends AbstractMutableBlock
{

    /**
     * 'ol' and 'ul'
     */
    const TYPES = [HtmlTags::HTML_TAG_LIST_ORDERED, HtmlTags::HTML_TAG_LIST_UNORDERED];

    /**
     * @var string
     */
    private $type;

    /**
     * HtmlList constructor.
     * @param string $type one of self::TYPES
     * @throws \Exception
     */
    public function __construct($type)
    {
        if (!in_array($type, self::TYPES)) {
            throw new \Exception("Unsupported List Type");
        }
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Render and return the string for the insert ready for the
     * renderer
     *
     * @return string
     */
    public function render()
    {
        return SimpleRenderer::tag($this->type, PHP_EOL.SimpleRenderer::children($this->children)).PHP_EOL;
    }
}