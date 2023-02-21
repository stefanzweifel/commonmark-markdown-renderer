<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\Config\ConfigurationInterface;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\StrongRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class StrongRendererTest extends TestCase
{
    private StrongRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new StrongRenderer();
        $this->renderer->setConfiguration($this->createConfiguration());
    }

    /** @test */
    public function it_renders_strong(): void
    {
        $block = new Strong();
        $fakeRenderer = new FakeChildNodeRenderer();
        $fakeRenderer->pretendChildrenExist();

        $result = $this->renderer->render($block, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals('**::children::**', $result);
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
