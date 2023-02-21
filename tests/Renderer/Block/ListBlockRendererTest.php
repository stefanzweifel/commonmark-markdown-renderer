<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListData;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\ListBlockRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class ListBlockRendererTest extends TestCase
{
    private ListBlockRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new ListBlockRenderer();
    }

    #[Test]
    public function it_renders_ordered_list_block(): void
    {
        $data = new ListData();
        $data->type = ListBlock::TYPE_ORDERED;
        $data->start = 0;

        $block = new ListBlock($data);
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("1. ::children::\n", $result);
    }

    #[Test]
    public function it_renders_unordered_list_block(): void
    {
        $data = new ListData();
        $data->type = ListBlock::TYPE_BULLET;
        $data->start = 0;

        $block = new ListBlock($data);
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("- ::children::\n", $result);
    }
}
