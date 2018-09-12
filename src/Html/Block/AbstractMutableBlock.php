<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 08/09/2018
 * Time: 02:19
 */

namespace Oberon\Quill\Render\Html\Block;

use Oberon\Quill\Render\Interfaces\Renderer;

/**
 * Class AbstractMutableBlock
 * @package Oberon\Quill\Render\Html\Block
 */
abstract class AbstractMutableBlock implements MutableBlock
{

    /**
     * @var Renderer[]
     */
    protected $children = [];

    /**
     * @param Renderer $renderer
     * @param int|null $index at which to add the inline;
     *                        null for at the end,
     *                        positive starting from start,
     *                        negative starting from end
     */
    public function addChild(Renderer $renderer, $index = null)
    {
        switch ($index) {
            case null:
            case $index >= 0 && $index >= count($this->children):
                $this->children[] = $renderer;
                break;
            case $index >= 0 && $index < count($this->children):
                array_splice($this->children, $index, $renderer);
                break;
            case $index < 0 && abs($index) >= count($this->children):
                array_unshift($this->children, $renderer);
                break;
            case $index < 0 && $index < count($this->children):
                array_splice($this->children, count($this->children) + $index, $renderer);
                break;
        }

    }

    /**
     * @return Renderer[]
     */
    public function getChildren()
    {
        return $this->children;
    }
}