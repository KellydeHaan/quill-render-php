<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 08/09/2018
 * Time: 02:07
 */

namespace Oberon\Quill\Render\Html\Block;

use Oberon\Quill\Render\Interfaces\Renderer;

interface MutableBlock extends Renderer
{

    /**
     * @param Renderer $renderer
     * @param int|null $index at which to add the inline;
     *                        null for at the end,
     *                        positive starting from start,
     *                        negative starting from end
     */
    public function addChild(Renderer $renderer, $index = null);

    /**
     * @return Renderer[]
     */
    public function getChildren();

}