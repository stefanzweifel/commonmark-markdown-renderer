<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class IndentedCodeRenderer implements NodeRendererInterface
{
    /**
     * @param IndentedCode $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        IndentedCode::assertInstanceOf($node);

        $content = $node->getLiteral();

        return <<<TXT
        ```{$content}```
        TXT;
    }
}
