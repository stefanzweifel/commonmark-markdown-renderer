<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

final class ListBlockRenderer implements \League\CommonMark\Renderer\NodeRendererInterface
{
    /**
     * @param ListBlock $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        ListBlock::assertInstanceOf($node);

        $listData = $node->getListData();

        $content = $childRenderer->renderNodes($node->children());
        $content = explode("\n", $content);

        if ($listData->type === ListBlock::TYPE_BULLET) {
            $content = array_map(fn($item) => "- {$item}", $content);
        }

        if ($listData->type === ListBlock::TYPE_ORDERED) {
            $returnArray = [];
            foreach ($content as $key => $value) {
                $key++;
                $returnArray[] = "{$key}. $value";
            }

            $content = $returnArray;
        }

        return implode("\n", $content) . "\n";
    }
}
