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
