<?php
/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */

final class ListTest extends \PHPUnit\Framework\TestCase
{
    private $delta_ordered = '{"ops":[{"insert":"Item 1"},{"attributes":{"list":"ordered"},"insert":"\n"},{"insert":"Item 2"},{"attributes":{"list":"ordered"},"insert":"\n"},{"insert":"Item 3"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_unordered = '{"ops":[{"insert":"Item 1"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"Item 2"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"Item 3"},{"attributes":{"list":"bullet"},"insert":"\n"}]}';
    private $delta_list_with_attribute = '{
        "ops":[
            {"insert":"List item 1"},
            {"attributes":{"list":"bullet"},"insert":"\n"},
            {"insert":"List "},
            {"attributes":{"bold":true},"insert":"item"},
            {"insert":" 2"},
            {"attributes":{"list":"bullet"},"insert":"\n"},
            {"insert":"List item 2"},
            {"attributes":{"list":"bullet"},"insert":"\n"}
        ]
    }';
    private $delta_single_item_list_bold = '{"ops":[{"attributes":{"bold":true},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_single_item_list_italic = '{"ops":[{"attributes":{"italic":true},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_single_item_list_strike = '{"ops":[{"attributes":{"strike":true},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_single_item_list_sub_script = '{"ops":[{"attributes":{"script":"sub"},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_single_item_list_super_script = '{"ops":[{"attributes":{"script":"super"},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_single_item_list_underline = '{"ops":[{"attributes":{"underline":true},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_single_item_list_link = '{"ops":[{"attributes":{"link":"link"},"insert":"List item 1"},{"attributes":{"list":"ordered"},"insert":"\n"}]}';
    private $delta_paragraph_then_list = '{"ops":[{"insert":"This is a single line of text.\nBullet 1"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"Bullet 2"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"Bullet 3"},{"attributes":{"list":"bullet"},"insert":"\n"}]}';
    private $delta_paragraph_then_list_then_paragraph = '{"ops":[{"insert":"This is a paragraph.\n\nList item 1"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"List item 2 "},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"List item 3"},{"attributes":{"list":"bullet"},"insert":"\n"},{"insert":"\nThis is another paragraph\n"}]}';
    private $delta_paragraph_then_list_then_paragraph_final_list_character_bold = '{"ops":[{"insert":"This is a paragraph.\n\nList item 1"},{"attributes":{"list":"ordered"},"insert":"\n"},{"insert":"List item 2"},{"attributes":{"list":"ordered"},"insert":"\n"},{"insert":"List item "},{"attributes":{"bold":true},"insert":"3"},{"attributes":{"list":"ordered"},"insert":"\n"},{"insert":"\nThis is another paragraph.\n"}]}';

    private $expected_ordered = '<ol>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ol>';
    private $expected_unordered = '<ul>
<li>Item 1</li>
<li>Item 2</li>
<li>Item 3</li>
</ul>';
    private $expected_list_with_attribute = '<ul>
<li>List item 1</li>
<li>List <strong>item</strong> 2</li>
<li>List item 2</li>
</ul>';
    private $expected_single_item_list_bold = '<ol>
<li><strong>List item 1</strong></li>
</ol>';
    private $expected_single_item_list_italic = '<ol>
<li><em>List item 1</em></li>
</ol>';
    private /** @noinspection HtmlUnknownTarget */
        $expected_single_item_list_link = '<ol>
<li><a href="link">List item 1</a></li>
</ol>';
    private $expected_single_item_list_sub_script = '<ol>
<li><sub>List item 1</sub></li>
</ol>';
    private $expected_single_item_list_super_script = '<ol>
<li><sup>List item 1</sup></li>
</ol>';
    private $expected_single_item_list_strike = '<ol>
<li><s>List item 1</s></li>
</ol>';
    private $expected_single_item_list_underline = '<ol>
<li><u>List item 1</u></li>
</ol>';
    private $expected_paragraph_then_list = '<p>This is a single line of text.</p>
<ul>
<li>Bullet 1</li>
<li>Bullet 2</li>
<li>Bullet 3</li>
</ul>';

    private $expected_paragraph_then_list_then_paragraph = '<p>This is a paragraph.</p>
<ul>
<li>List item 1</li>
<li>List item 2 </li>
<li>List item 3</li>
</ul>
<p>This is another paragraph</p>';

    private $expected_paragraph_then_list_then_paragraph_final_list_character_bold = '<p>This is a paragraph.</p>
<ol>
<li>List item 1</li>
<li>List item 2</li>
<li>List item <strong>3</strong></li>
</ol>
<p>This is another paragraph.</p>';

    /**
     * Ordered list
     *
     * @return void
     * @throws \Exception
     */
    public function testListOrdered()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_ordered);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals($this->expected_ordered, trim($result), __METHOD__.' Ordered list failure');
    }

    /**
     * Unordered list
     *
     * @return void
     * @throws \Exception
     */
    public function testListBullet()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_unordered);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals($this->expected_unordered, trim($result), __METHOD__.' Unordered list failure');
    }

    /**
     * Unordered list
     *
     * @return void
     * @throws \Exception
     */
    public function testListWithAttribute()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_list_with_attribute);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals($this->expected_list_with_attribute, trim($result), __METHOD__.' Unordered list failure');
    }

    /**
     * Single item list, entire list item bold
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemBold()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_bold);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_bold,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Single item list, entire list item italic
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemItalic()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_italic);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_italic,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Single item list, entire list item strike through
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemStrike()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_strike);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_strike,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Single item list, entire list item sub script
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemSubScript()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_sub_script);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_sub_script,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Single item list, entire list item super script
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemSuperScript()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_super_script);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_super_script,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Single item list, entire list item underline
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemUnderline()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_underline);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_underline,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Single item list, entire list item a link
     *
     * @return void
     * @throws \Exception
     */
    public function testSingleListItemLink()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_single_item_list_link);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_single_item_list_link,
            trim($result),
            __METHOD__.' Single list item failure'
        );
    }

    /**
     * Test a paragraph followed by a list
     *
     * @return void
     * @throws \Exception
     */
    public function testParagraphThenList()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_paragraph_then_list);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_paragraph_then_list,
            trim($result),
            __METHOD__.' Paragraph then list failure'
        );
    }

    /**
     * Test a paragraph followed by a list and then a final paragraph
     *
     * @return void
     * @throws \Exception
     */
    public function testParagraphThenListTheParagraph()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_paragraph_then_list_then_paragraph);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_paragraph_then_list_then_paragraph,
            trim($result),
            __METHOD__.' Paragraph then list then paragraph failure'
        );
    }

    /**
     * Test a paragraph followed by a list and then a final paragraph, the final character in the list is bold
     *
     * @return void
     * @throws \Exception
     */
    public function testParagraphThenListTheParagraphPlusBoldAttribute()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill(
                $this->delta_paragraph_then_list_then_paragraph_final_list_character_bold
            );
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_paragraph_then_list_then_paragraph_final_list_character_bold,
            trim($result),
            __METHOD__.' Paragraph then list then paragraph failure'
        );
    }
}