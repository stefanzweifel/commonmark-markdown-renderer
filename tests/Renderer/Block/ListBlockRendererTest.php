<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListData;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\Text;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\ListBlockRenderer;
use Wnx\CommonmarkMarkdownRenderer\Renderer\MarkdownRenderer;

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
        // Build up Children
        $data = new ListData();
        $data->type = ListBlock::TYPE_ORDERED;
        $data->start = 1;
        $data->padding = 3;
        $data->delimiter = 'period';
        $data->bulletChar = '-';

        $listItem = new ListItem($data);

        $paragraph = new Paragraph();
        $paragraph->appendChild(new Text('List Item Value'));
        $listItem->appendChild($paragraph);

        $block = new ListBlock($data);
        $block->appendChild($listItem);

        // Build up Child Renderer
        $environment = new Environment();
        $environment->addExtension(new MarkdownRendererExtension());
        $childRenderer = new MarkdownRenderer($environment);

        // Render AST
        $result = $this->renderer->render($block, $childRenderer);

        // Assert
        $this->assertIsString($result);
        $this->assertEquals("1. List Item Value\n", $result);
    }

    #[Test]
    public function it_renders_unordered_list_block(): void
    {
        // Build up Children
        $data = new ListData();
        $data->type = ListBlock::TYPE_BULLET;
        $data->padding = 2;
        $data->bulletChar = '-';

        $listItem = new ListItem($data);

        $paragraph = new Paragraph();
        $paragraph->appendChild(new Text('List Item Value'));
        $listItem->appendChild($paragraph);

        $block = new ListBlock($data);
        $block->appendChild($listItem);

        // Build up Child Renderer
        $environment = new Environment();
        $environment->addExtension(new MarkdownRendererExtension());
        $childRenderer = new MarkdownRenderer($environment);

        // Render AST
        $result = $this->renderer->render($block, $childRenderer);

        $this->assertIsString($result);
        $this->assertEquals("- List Item Value\n", $result);
    }
}
