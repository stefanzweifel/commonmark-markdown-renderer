<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Block\Document;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    #[DataProvider('provide_fenced_code')]
    public function it_renders_fenced_code(array $fencedArgs, string $expected): void
    {
        $document = new Document();

        $block = new FencedCode(...$fencedArgs);
        $block->setInfo('php');
        $block->setLiteral('echo "hello world!";');
        $block->data->set('attributes', ['id' => 'foo', 'class' => 'bar']);

        $document->appendChild($block);

        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertEquals($expected, $result);
    }

    public function provide_fenced_code(): array
    {
        return [
            'tilde as char' => [
                'fencedArgs' => [3, '~', 0],
                'expected' => <<<TXT
                ~~~php
                echo "hello world!";
                ~~~
                TXT
            ],
            'backtick as char' => [
                'fencedArgs' => [3, '`', 0],
                'expected' => <<<TXT
                ```php
                echo "hello world!";
                ```
                TXT
            ],
            'offset and >3 chars' => [
                'fencedArgs' => [5, '`', 2],
                'expected' => <<<TXT
                  `````php
                  echo "hello world!";
                  `````
                TXT
            ],
        ];
    }
}
