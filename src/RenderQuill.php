<?php

namespace Oberon\Quill\Render;

use Oberon\Quill\Render\Interfaces\Parser;
use Oberon\Quill\Render\Interfaces\Renderer;

class RenderQuill
{
    /**
     * The initial quill json string after it has been json decoded
     *
     * @var array
     */
    protected $quillJson;

    /**
     * RenderableFactories to be used
     *
     * @var Parser[]
     */
    protected $parsers;

    /**
     * Result of parse() function
     *
     * @var Renderer[]
     */
    protected $renderers;

    /**
     * Is the json array or group of arrays valid and able to be decoded
     *
     * @param boolean
     */
    protected $valid = false;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->quillJson = null;
        $this->parsers = [];
    }

    /**
     * Load the deltas string, checks the json is valid and can be decoded
     * and then saves the decoded array to the the $quillJson property
     *
     * @param string $quillJson src json string
     *
     * @return RenderQuill
     * @throws \InvalidArgumentException Throws an exception if there was an error decoding the json
     */
    public function load($quillJson)
    {
        $this->quillJson = json_decode($quillJson, true);

        if (is_array($this->quillJson) === true && count($this->quillJson) > 0) {
            $this->valid = true;
            $this->renderers = [];
        } else {
            throw new \InvalidArgumentException('Unable to decode the json');
        }

        $this->parse();

        return $this;
    }

    private function parse()
    {
        if (
            $this->valid === true &&
            array_key_exists('ops', $this->quillJson) === true
        ) {
            $this->quillJson = $this->quillJson['ops'];
            foreach ($this->quillJson as $quill) {

                if ($quill['insert'] !== null) {

                    foreach ($this->parsers as $factory) {
                        if ($factory->handleOp($quill, $this->renderers)) {
                            break;
                        }
                    }
                }
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate the final output string from the Renderable[]
     *
     * @param boolean $trim Optionally trim the output
     *
     * @return string
     */
    public function render($trim = true)
    {
        $result = '';
        foreach ($this->renderers as $renderer) {
            $result .= $renderer->render();
        }
        if ($trim) {
            $result = trim($result);
        }

        return $result;
    }

    /**
     * @param Parser[] $parsers
     */
    public function setParsers($parsers)
    {
        $this->parsers = $parsers;
    }

}