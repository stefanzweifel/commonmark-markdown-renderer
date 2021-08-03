<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Block;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Block\HtmlBlock;
use League\Config\ConfigurationInterface;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Block\HtmlBlockRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

class HtmlBlockRendererTest extends TestCase
{
    private HtmlBlockRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new HtmlBlockRenderer();
        $this->renderer->setConfiguration($this->createConfiguration());
    }

    /** @test */
    public function it_renders_paragraph()
    {
        $block = new HtmlBlock(HtmlBlock::TYPE_2_COMMENT);
        $block->setLiteral("<!-- This is a comment -->");
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('<!-- This is a comment -->', $result);
    }

    /**
     * @param array<string, mixed> $values
     */
    private function createConfiguration(array $values = []): ConfigurationInterface
    {
        $config = Environment::createDefaultConfiguration();
        (new MarkdownRendererExtension())->configureSchema($config);
        $config->merge($values);

        return $config->reader();
    }
}
