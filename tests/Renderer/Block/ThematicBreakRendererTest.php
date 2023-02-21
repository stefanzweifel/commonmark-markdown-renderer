<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\ThematicBreakRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class ThematicBreakRendererTest extends TestCase
{
    private ThematicBreakRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new ThematicBreakRenderer();
    }

    /** @test */
    public function it_renders_thematic_break(): void
    {
        $block = new ThematicBreak();
        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertEquals("\n---\n", $result);
    }
}
