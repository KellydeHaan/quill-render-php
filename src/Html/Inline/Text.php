<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 11/09/2018
 * Time: 14:19
 */

namespace Oberon\Quill\Render\Html\Inline;

use Oberon\Quill\Render\Interfaces\Renderer;

class Text implements Renderer
{

    private $text;

    /**
     * Text constructor.
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Render and return the string for the insert ready for the
     * renderer
     *
     * @return string
     */
    public function render()
    {
        return $this->text;
    }
}