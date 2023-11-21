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

        $content = [];
        foreach (explode("\n", $node->getLiteral()) as $line) {
            if ($line === '') {
                $content[] = null;

                continue;
            }

            $content[] = "    {$line}";
        }

        return implode("\n", $content);
    }
}
