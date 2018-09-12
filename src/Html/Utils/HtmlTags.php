<?php
/**
 * Created by PhpStorm.
 * User: kelly
 * Date: 11/09/2018
 * Time: 11:44
 */

namespace Oberon\Quill\Render\Html\Utils;

use Oberon\Quill\Render\Attribute;

/**
 * Class HtmlTags
 * @package Oberon\Quill\Render\Delta\Html
 */
class HtmlTags
{

    const HTML_TAG_BOLD = 'strong';
    const HTML_TAG_ITALIC = 'em';
    const HTML_TAG_SUPER_SCRIPT = 'sup';
    const HTML_TAG_SUB_SCRIPT = 'sub';
    const HTML_TAG_UNDERLINE = 'u';
    const HTML_TAG_STRIKE = 's';
    const HTML_TAG_HEADER = 'h';
    const HTML_TAG_LIST_ITEM = 'li';
    const HTML_TAG_LIST_ORDERED = 'ol';
    const HTML_TAG_LIST_UNORDERED = 'ul';

    /**
     * array[string => array[string => string] | string]
     */
    const QUILL_TO_HTML_MAP = [
        Attribute::BOLD => self::HTML_TAG_BOLD,
        Attribute::HEADER => self::HTML_TAG_HEADER,
        Attribute::ITALIC => self::HTML_TAG_ITALIC,
        Attribute::LIST_ITEM => self::HTML_TAG_LIST_ITEM,
        Attribute::LIST_ORDERED => self::HTML_TAG_LIST_ORDERED,
        Attribute::LIST_BULLET => self::HTML_TAG_LIST_UNORDERED,
        Attribute::SCRIPT => [
            Attribute::SCRIPT_SUB => self::HTML_TAG_SUB_SCRIPT,
            Attribute::SCRIPT_SUPER => self::HTML_TAG_SUPER_SCRIPT,
        ],
        Attribute::STRIKE => self::HTML_TAG_STRIKE,
        Attribute::UNDERLINE => self::HTML_TAG_UNDERLINE,
    ];

    /**
     * @param string $quillAttr
     * @param string $value
     * @return string|null
     */
    public static function toHtmlTag($quillAttr, $value)
    {
        if (key_exists($quillAttr, self::QUILL_TO_HTML_MAP)) {
            $html = self::QUILL_TO_HTML_MAP[$quillAttr];
            if (is_string($html)) {
                return $html;
            } elseif (is_array($html)) {
                return $html[$value];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

}