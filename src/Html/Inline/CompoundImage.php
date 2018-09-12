<?php

namespace Oberon\Quill\Render\Html\Inline;

use Oberon\Quill\Render\Interfaces\Renderer;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
class CompoundImage implements Renderer
{
    private $insert;
    private $attributes = [];

    /**
     * Set the initial properties for the delta
     *
     * @param string $insert
     */
    public function __construct($insert)
    {
        $this->insert = $insert;
    }

    /**
     * Pass in an attribute value for conversion
     *
     * @param string $attribute Attribute name
     * @param string $value Attribute value to assign
     *
     * @return CompoundImage
     */
    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = $value;

        return $this;
    }

    /**
     * Render the HTML for the specific Delta type
     *
     * @return string
     */
    public function render()
    {
        $image_attributes = '';
        foreach ($this->attributes as $attribute => $value) {
            $image_attributes .= "{$attribute}=\"{$value}\" ";
        }

        return "<img src=\"{$this->insert}\" {$image_attributes}/>";
    }
}
