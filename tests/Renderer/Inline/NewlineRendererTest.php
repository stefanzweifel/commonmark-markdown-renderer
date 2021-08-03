<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Node\Inline\Newline;
use League\Config\ConfigurationInterface;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\NewlineRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

class NewlineRendererTest extends TestCase
{
    private NewlineRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new NewlineRenderer();
    }

    /** @test */
    public function it_renders_hardbreak_new_line()
    {
        $inline = new Newline(Newline::HARDBREAK);
        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($inline, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("\n", $result);
    }

    /** @test */
    public function it_renders_softbreak_new_line()
    {
        $inline = new Newline(Newline::SOFTBREAK);
        $fakeRenderer = new FakeChildNodeRenderer();
        $this->renderer->setConfiguration($this->createConfiguration(['renderer' => ['soft_break' => '::softbreakChar::']]));

        $result = $this->renderer->render($inline, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("::softbreakChar::", $result);
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
