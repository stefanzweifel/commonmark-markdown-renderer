<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\Config\ConfigurationInterface;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\LinkRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

class LinkRendererTest extends TestCase
{
    private LinkRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new LinkRenderer();
        $this->renderer->setConfiguration($this->createConfiguration());
    }

    /** @test */
    public function it_renders_link()
    {
        $inline = new Link('http://example.com/foo.html', '::label::', '::title::');
        $inline->data->set('attributes', ['id' => '::id::', 'title' => '::title2::', 'href' => '::href2::']);
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($inline, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('[::children::](http://example.com/foo.html "::title::")', $result);
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
