<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Block\Document;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\FencedCodeRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class FencedCodeRendererTest extends TestCase
{
    private FencedCodeRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new FencedCodeRenderer();
    }

    /** @test */
    public function it_renders_fenced_code(): void
    {
        $document = new Document();

        $block = new FencedCode(3, '~', 0);
        $block->setInfo('php');
        $block->setLiteral('echo "hello world!";');
        $block->data->set('attributes', ['id' => 'foo', 'class' => 'bar']);

        $document->appendChild($block);

        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertEquals(<<<TXT
        ```php
        echo "hello world!";
        ```
        TXT, $result);
    }
}
