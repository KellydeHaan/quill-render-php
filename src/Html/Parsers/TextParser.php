<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 07/09/2018
 * Time: 17:07
 */

namespace Oberon\Quill\Render\Html\Parsers;

use Oberon\Quill\Render\Html\Block\Paragraph;
use Oberon\Quill\Render\Html\Inline\Text;
use Oberon\Quill\Render\Html\Utils\InlineUtil;
use Oberon\Quill\Render\Interfaces\Parser;

class TextParser implements Parser
{

    /**
     * @param array $op
     * @param array $renderers passed by reference, might be modified
     * @return boolean returns true if the op was fully handled, false otherwise
     */
    public function handleOp(array $op, array & $renderers)
    {
        if (!$this->checkRequirements($op)) {
            return false;
        }

        $this->splitInsertsOnNewLine($op['insert'], $renderers);

        return true;
    }

    private function checkRequirements(array $op)
    {
        return (!key_exists('attributes', $op))
            && key_exists('insert', $op)
            && is_string($op['insert']);
    }

    private function splitInsertsOnNewLine($insert, &$renderables)
    {
        $endsWithNewLine = (substr($insert, -1) == "\n");

        if (preg_match("/\n+/", rtrim($insert, "\n")) !== 0) {
            $matches = preg_split("/\n+/", rtrim($insert, "\n"));
            $i = 0;
            foreach ($matches as $match) {
                if (strlen(trim($match)) > 0) {
                    $text = new Text(str_replace("\n", '', $match));
                    InlineUtil::addToParagraph($text, $renderables);
                }

                $i++;
                if ($i < count($matches)) {
                    $renderables[] = new Paragraph();
                }

            }
        } else {

            $text = new Text(rtrim($insert, "\n"));
            InlineUtil::addToParagraph($text, $renderables);
        }

        if ($endsWithNewLine) {
            $renderables[] = new Paragraph();
        }
    }
}