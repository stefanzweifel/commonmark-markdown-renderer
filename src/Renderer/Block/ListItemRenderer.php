<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Extension\CommonMark\Node\Block\ListData;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\TaskList\TaskListItemMarker;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use LogicException;

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

        $listData = $node->getListData();

        $contents = $childRenderer->renderNodes($node->children());

        $contents = $this->addPadding($listData->padding, $contents);

        if (str_starts_with($contents, '<') && ! $this->startsTaskListItem($node)) {
            $contents = "\n" . $contents;
        }

        if (str_ends_with($contents, '>')) {
            $contents .= "\n";
        }

        $contents = $this->addBulletChar($listData, $contents);

        return $contents;
    }

    private function addPadding(int $paddingLevel, string $content): string
    {
        $padding = str_repeat(' ', $paddingLevel);
        $lines = [];
        $isFirstLine = true;
        foreach (explode("\n", $content) as $line) {
            // We don't need to indent the first line.
            if ($isFirstLine) {
                $isFirstLine = false;
            } else {
                $line = "{$padding}{$line}";
            }
            $lines[] = $line;
        }
        return implode("\n", $lines);
    }

    private function startsTaskListItem(ListItem $block): bool
    {
        $firstChild = $block->firstChild();

        return $firstChild instanceof Paragraph && $firstChild->firstChild() instanceof TaskListItemMarker;
    }

    private function addBulletChar(ListData $listData, string $content): string
    {
        switch ($listData->type) {
            case ListBlock::TYPE_BULLET:
                return "{$listData->bulletChar} {$content}";
            case ListBlock::TYPE_ORDERED:
                switch ($listData->delimiter) {
                    case ListBlock::DELIM_PAREN:
                        $delimiter = ')';
                        break;
                    case ListBlock::DELIM_PERIOD:
                        $delimiter = '.';
                        break;
                    default:
                        throw new LogicException('Unexpected list delimiter: ' . $listData->delimiter);
                }
                return "{$listData->start}{$delimiter} $content";
            default:
                throw new LogicException('Unexpected list type: ' . $listData->type);
        }
    }
}
