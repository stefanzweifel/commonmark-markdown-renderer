<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Node\Block\Document;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\DocumentRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class DocumentRendererTest extends TestCase
{
    private DocumentRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new DocumentRenderer();
    }

    #[Test]
    public function it_renders_document(): void
    {
        $block = new Document();
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('::children::', $result);
    }
}
