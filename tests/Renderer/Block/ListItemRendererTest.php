<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\ListData;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\ListItemRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

class ListItemRendererTest extends TestCase
{
    private ListItemRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new ListItemRenderer();
    }

    /** @test */
    public function it_renders_unordered_list()
    {
        $block = new ListItem(new ListData());
        $block->data->set('attributes/id', 'foo');
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertEquals('::children::', $result);
    }
}
