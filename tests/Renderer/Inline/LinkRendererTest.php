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

final class LinkRendererTest extends TestCase
{
    private LinkRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new LinkRenderer();
        $this->renderer->setConfiguration($this->createConfiguration());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_renders_link(): void
    {
        $inline = new Link('http://example.com/foo.html', '::label::', '::title::');
        $inline->data->set('attributes', ['id' => '::id::', 'title' => '::title2::', 'href' => '::href2::']);
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($inline, $fakeRenderer);

        $this->assertEquals('[::children::](http://example.com/foo.html "::title::")', $result);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_renders_unsafe_link_with_empty_url_when_unsafe_links_are_forbidden(): void
    {
        $renderer = new LinkRenderer();
        $renderer->setConfiguration($this->createConfiguration(['allow_unsafe_links' => false]));
        $inline = new Link('javascript:void(0)', '::label::');
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $renderer->render($inline, $fakeRenderer);

        $this->assertEquals('[::children::]()', $result);
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
