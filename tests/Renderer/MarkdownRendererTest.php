<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Parser\MarkdownParser;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\MarkdownRenderer;

class MarkdownRendererTest extends TestCase
{
    private MarkdownParser $parser;

    private MarkdownRenderer $renderer;

    protected function setUp(): void
    {
        $environment = new Environment();
        $environment->addExtension(new MarkdownRendererExtension());

        $this->parser = new MarkdownParser($environment);
        $this->renderer = new MarkdownRenderer($environment);
    }

    /** @test */
    public function it_renders_ast_to_markdown()
    {
        $document = $this->parser->parse("# Hello World");

        $result = $this->renderer->renderDocument($document)->getContent();

        $this->assertIsString($result);
        $this->assertEquals('# Hello World', $result);
    }

    /** @test */
    public function it_parses_and_renders_kitchen_sink()
    {
        $contentKitchenSink = file_get_contents(__DIR__ . '/../stubs/kitchen-sink.md');

        $document = $this->parser->parse($contentKitchenSink);

        $result = $this->renderer->renderDocument($document)->getContent();

        $this->assertEquals($contentKitchenSink, $result);
    }
}
