<?php

use Oberon\Quill\Render\Html\DefaultHtmlParsers;
use Oberon\Quill\Render\RenderQuill;

/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
final class StockTest extends \PHPUnit\Framework\TestCase
{
    private $delta_null_insert = '{"ops":[{"insert":"Heading 1"},{"insert":null},{"attributes":{"header":1},"insert":"\n"}]}';
    private $delta_header = '{"ops":[{"insert":"Heading 1"},{"attributes":{"header":1},"insert":"\n"}]}';
    private $delta_header_invalid = '{"ops":[{"insert":"Heading 1"},{"attributes":{"header":1},"insert":"\n"}}';

    private $expected_null_insert = "<h1>Heading 1</h1>";
    private $expected_header = '<h1>Heading 1</h1>';

    /**
     * Test to ensure null insert skipped
     *
     * @return void
     * @throws \Exception
     */
    public function testNullInsertSkipped()
    {
        $result = null;

        try {
            $quill = new RenderQuill();
            $quill->setParsers(DefaultHtmlParsers::get());
            $quill->load($this->delta_null_insert);
            $result = $quill->render(true);
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_null_insert,
            trim($result),
            __METHOD__.' Null insert skipped failure'
        );
    }

    /**
     * Test reusing the DynamicParser
     *
     * @return void
     * @throws \Exception
     */
    public function testMultipleInstancesInScript()
    {
        $result = null;

        $parser = new RenderQuill();
        $parser->setParsers(DefaultHtmlParsers::get());

        try {
            $parser->load($this->delta_header);

            $result = $parser->render(true);

            $parser->load($this->delta_header);

            $result = $parser->render();

        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals(
            $this->expected_header,
            trim($result),
            __METHOD__.' Multiple load calls failure'
        );
    }

    /**
     * Test to see if an exception is thrown when attempting to parse an invalid json string
     *
     * @return void
     * @throws \Exception
     */
    public function testExceptionThrownForInvalidJson()
    {
        $this->expectException(\InvalidArgumentException::class);

        $parser = new RenderQuill();
        $parser->load($this->delta_header_invalid);
    }
}