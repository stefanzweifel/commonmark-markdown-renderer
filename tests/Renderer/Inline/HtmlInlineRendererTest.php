<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\Config\ConfigurationInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\HtmlInlineRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class HtmlInlineRendererTest extends TestCase
{
    private HtmlInlineRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new HtmlInlineRenderer();
        $this->renderer->setConfiguration($this->createConfiguration());
    }

    #[Test]
    public function it_renders_inline_html(): void
    {
        $block = new HtmlInline("<h1>Test</h1>");
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('<h1>Test</h1>', $result);
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
