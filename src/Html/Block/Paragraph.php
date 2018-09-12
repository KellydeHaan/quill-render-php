<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 07/09/2018
 * Time: 17:14
 */

namespace Oberon\Quill\Render\Html\Block;

class Paragraph extends AbstractMutableBlock
{

    /**
     * Render and return the string for the insert ready for the relevant
     * renderer
     *
     * @return string
     */
    public function render()
    {
        $insert = SimpleRenderer::children($this->children);
        if (empty($insert)) {
            return '';
        } else {
            return "<p>{$insert}</p>".PHP_EOL;
        }
    }

}