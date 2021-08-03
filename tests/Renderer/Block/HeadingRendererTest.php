<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\HeadingRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

class HeadingRendererTest extends TestCase
{
    private HeadingRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new HeadingRenderer();
    }

    /** @test */
    public function it_renders_heading()
    {
        $block = new Heading(1);

        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('# ::children::', $result);
    }
}
