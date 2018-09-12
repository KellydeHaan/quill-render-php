<?php
/**
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */

final class VideoTest extends \PHPUnit\Framework\TestCase
{
    private $delta_video = '{"ops":[{"insert":{"video":"https://video.url"}},{"insert":"\n"}]}';

    private $expected_video = <<<'EXPECTED'
<p><iframe class="ql-video" frameborder="0" allowfullscreen="true" src="https://video.url"></iframe></p>
EXPECTED;


    /**
     * Video
     *
     * @return void
     * @throws \Exception
     */
    public function testVideo()
    {
        $result = null;

        try {
            $quill = \Oberon\Quill\Render\Html\HtmlParser::withQuill($this->delta_video);
            $result = $quill->render();
        } catch (\Exception $e) {
            $this->fail(__METHOD__.'failure, '.$e->getMessage());
        }

        $this->assertEquals($this->expected_video, trim($result), __METHOD__.' Video failure');
    }
}