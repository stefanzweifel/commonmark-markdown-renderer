<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\BlockQuoteRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class BlockQuoteRendererTest extends TestCase
{
    private BlockQuoteRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new BlockQuoteRenderer();
    }

    /** @test */
    public function it_renders_block_quote(): void
    {
        $block = new BlockQuote();
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('> ::children::', $result);
    }
}
