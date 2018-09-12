<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 12/09/2018
 * Time: 10:31
 */

namespace Oberon\Quill\Render\Html\Inline;

use Oberon\Quill\Render\Interfaces\Renderer;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
class Link implements Renderer
{

    private $url;
    private $text;

    /**
     * Link constructor.
     * @param string $url
     * @param string $text
     */
    public function __construct($url, $text)
    {
        $this->url = $url;
        $this->text = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
    }

    /**
     * Render and return the string for the insert ready for the
     * renderer
     *
     * @return string
     */
    public function render()
    {
        return "<a href=\"{$this->url}\">{$this->text}</a>";
    }
}