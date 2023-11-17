<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Node\Block\Document;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\IndentedCodeRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class IndentedCodeRendererTest extends TestCase
{
    private IndentedCodeRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new IndentedCodeRenderer();
    }

    #[Test]
    public function it_renders_indented_code_renderer(): void
    {
        $document = new Document();

        $block = new IndentedCode();
        $block->data->set('attributes/id', 'foo');
        $block->setLiteral('echo "hello world!";');

        $document->appendChild($block);

        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertEquals('    echo "hello world!";', $result);
    }
}
