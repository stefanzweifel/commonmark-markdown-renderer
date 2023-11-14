<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\Config\ConfigurationInterface;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\EmphasisRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class EmphasisRendererTest extends TestCase
{
    private EmphasisRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new EmphasisRenderer();
        $this->renderer->setConfiguration($this->createConfiguration());
    }

    #[Test]
    public function it_renders_emphasis_using_asterisk(): void
    {
        $block = new Emphasis();
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('*::children::*', $result);
    }

    #[Test]
    public function it_renders_emphasis_using_underscore(): void
    {
        $block = new Emphasis('_');
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $this->renderer->setConfiguration($this->createConfiguration([
            'commonmark' => [
                'use_asterisk' => false,
            ],
        ]));

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('_::children::_', $result);
    }

    #[Test]
    public function it_renders_emphasis_with_whatever_delimiter_used(): void
    {
        $block = new Emphasis('$');
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $this->renderer->setConfiguration($this->createConfiguration([
            'commonmark' => [
                'use_asterisk' => false,
                'use_underscore' => false,
            ],
        ]));

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('$::children::$', $result);
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
