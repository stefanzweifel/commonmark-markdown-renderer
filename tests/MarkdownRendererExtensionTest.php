<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Parser\MarkdownParser;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\MarkdownRenderer;

final class MarkdownRendererExtensionTest extends TestCase
{
    /**
     * @dataProvider getTestData
     *
     * @param array<string, mixed> $config
     */
    public function test_markdown_renderer_extension_works(string $markdown, array $config, string $expected): void
    {
        $environment = new Environment($config);
        $environment->addExtension(new MarkdownRendererExtension());

        $parser = new MarkdownParser($environment);
        $renderer = new MarkdownRenderer($environment);

        $this->assertSame($expected, (string) $renderer->renderDocument($parser->parse($markdown)));
    }

    /**
     * @return iterable<array<mixed>>
     */
    public function getTestData(): \Iterator
    {
        yield ['*Emphasis*', [], "*Emphasis*\n"];
        yield ['**Strong**', [], "**Strong**\n"];
        yield ['_Emphasis_', [], "*Emphasis*\n"];
        yield ['__Strong__', [], "**Strong**\n"];

        yield ['*Emphasis*', ['commonmark' => ['enable_em' => true]], "*Emphasis*\n"];
        yield ['**Strong**', ['commonmark' => ['enable_strong' => true]], "**Strong**\n"];
        yield ['_Emphasis_', ['commonmark' => ['use_underscore' => true, 'use_asterisk' => false]], "_Emphasis_\n"];
        yield ['__Strong__', ['commonmark' => ['use_underscore' => true, 'use_asterisk' => false]], "__Strong__\n"];

        yield ['*Emphasis*', ['commonmark' => ['enable_em' => false]], "*Emphasis*\n"];
        yield ['**Strong**', ['commonmark' => ['enable_strong' => false]], "**Strong**\n"];
        yield ['_Emphasis_', ['commonmark' => ['use_underscore' => false, 'use_asterisk' => false]], "_Emphasis_\n"];
        yield ['__Strong__', ['commonmark' => ['use_underscore' => false, 'use_asterisk' => false]], "__Strong__\n"];
    }
}
