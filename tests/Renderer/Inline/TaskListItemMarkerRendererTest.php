<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Tests\Renderer\Inline;

use League\CommonMark\Extension\TaskList\TaskListItemMarker;
use PHPUnit\Framework\TestCase;
use Wnx\CommonmarkMarkdownRenderer\Renderer\Inline\TaskListItemMarkerRenderer;
use Wnx\CommonmarkMarkdownRenderer\Tests\Support\FakeChildNodeRenderer;

final class TaskListItemMarkerRendererTest extends TestCase
{
    private TaskListItemMarkerRenderer $renderer;

    protected function setUp(): void
    {
        $this->renderer = new TaskListItemMarkerRenderer();
    }

    /** @test */
    public function it_renders_unchecked_task_list_item(): void
    {
        $node = new TaskListItemMarker(false);
        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($node, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("[ ]", $result);
    }

    /** @test */
    public function it_renders_checked_task_list_item(): void
    {
        $node = new TaskListItemMarker(true);
        $fakeRenderer = new FakeChildNodeRenderer();

        $result = $this->renderer->render($node, $fakeRenderer);

        $this->assertIsString($result);
        $this->assertEquals("[x]", $result);
    }
}
