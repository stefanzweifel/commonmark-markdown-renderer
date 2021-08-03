<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Node\Block\Paragraph;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\ParagraphRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

class ParagraphRendererTest extends TestCase
{
    private ParagraphRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new ParagraphRenderer();
    }

    /** @test */
    public function it_renders_paragraph()
    {
        $block = new Paragraph();
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("::children::\n", $result);
    }
}
