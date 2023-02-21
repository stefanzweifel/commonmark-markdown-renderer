<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Node\Inline\Text;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\TextRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class TextRendererTest extends TestCase
{
    private TextRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new TextRenderer();
    }

    #[Test]
    public function it_renders_paragraph(): void
    {
        $block = new Text('Foo Bar');
        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('Foo Bar', $result);
    }
}
