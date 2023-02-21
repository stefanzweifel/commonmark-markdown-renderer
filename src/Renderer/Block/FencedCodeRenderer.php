<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Block;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

final class FencedCodeRenderer implements NodeRendererInterface
{
    /**
     * @param FencedCode $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        FencedCode::assertInstanceOf($node);

        $attrs = $node->data->getData('attributes');

        $infoWords = $node->getInfoWords();
        $language = null;
        if (\count($infoWords) !== 0 && $infoWords[0] !== '') {
            $attrs->append('class', 'language-' . $infoWords[0]);
            $language = $infoWords[0];
        }

        $content = $node->getLiteral();

        return <<<TXT
        ```{$language}
        {$content}
        ```
        TXT;
    }
}
