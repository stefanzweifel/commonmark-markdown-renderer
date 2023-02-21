<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class HeadingRenderer implements NodeRendererInterface
{
    /**
     * @param Heading $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        Heading::assertInstanceOf($node);

        $level = str_repeat("#", $node->getLevel());

        $content = $childRenderer->renderNodes($node->children());

        return "$level $content\n";
    }
}
