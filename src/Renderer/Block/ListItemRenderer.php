<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\TaskList\TaskListItemMarker;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

final class ListItemRenderer implements \League\CommonMark\Renderer\NodeRendererInterface
{
    public const INLINE_LINE_BREAK = '_COMMONMARK_MARKDOWN_RENDERER_LINE_BREAK_';

    /**
     * @param ListItem $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        ListItem::assertInstanceOf($node);

        $contents = $childRenderer->renderNodes($node->children());

        // If the ListItem contains a line break, replace the line break with a custom string.
        // The custom line break string is being replaced with a _native_ line break again, when
        // being rendered in a ListBlock.
        // This workaround is required to support multi-line list items.
        if (str_contains($contents, "\n")) {
            $contents = str_replace("\n", self::INLINE_LINE_BREAK, $contents);
        }

        if (str_starts_with($contents, '<') && ! $this->startsTaskListItem($node)) {
            $contents = "\n" . $contents;
        }

        if (str_ends_with($contents, '>')) {
            $contents .= "\n";
        }

        return "{$contents}";
    }

    private function startsTaskListItem(ListItem $block): bool
    {
        $firstChild = $block->firstChild();

        return $firstChild instanceof Paragraph && $firstChild->firstChild() instanceof TaskListItemMarker;
    }
}
