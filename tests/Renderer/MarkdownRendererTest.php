<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Parser\MarkdownParser;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\MarkdownRenderer;

final class MarkdownRendererTest extends TestCase
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

    #[Test]
    public function it_renders_ast_to_markdown(): void
    {
        $document = $this->parser->parse("# Hello World");

        $result = $this->renderer->renderDocument($document)->getContent();

        $this->assertIsString($result);
        $this->assertEquals("# Hello World\n", $result);
    }

    #[Test]
    public function it_parses_and_renders_kitchen_sink(): void
    {
        $contentKitchenSink = file_get_contents(__DIR__ . '/../stubs/kitchen-sink.md');
        $contentKitchenSinkExpected = file_get_contents(__DIR__ . '/../stubs/kitchen-sink-expected.md');

        $document = $this->parser->parse($contentKitchenSink);

        $result = $this->renderer->renderDocument($document)->getContent();

        $this->assertEquals($contentKitchenSinkExpected, $result);
    }

    #[Test]
    public function it_parses_kitchen_sink_and_parsing_the_result_again_returns_the_same_result(): void
    {
        $contentKitchenSink = file_get_contents(__DIR__ . '/../stubs/kitchen-sink.md');
        $contentKitchenSinkExpected = file_get_contents(__DIR__ . '/../stubs/kitchen-sink-expected.md');

        $document = $this->parser->parse($contentKitchenSink);

        $result = $this->renderer->renderDocument($document)->getContent();
        $this->assertEquals($contentKitchenSinkExpected, $result);

        // Take the result and parse it again
        $document = $this->parser->parse($result);
        $result = $this->renderer->renderDocument($document)->getContent();
        $this->assertEquals($contentKitchenSinkExpected, $result);
    }
}
