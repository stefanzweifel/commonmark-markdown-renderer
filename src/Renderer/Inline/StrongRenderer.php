<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

final class StrongRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    /** @psalm-readonly-allow-private-mutation */
    private ConfigurationInterface $config;

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    /**
     * @param Strong $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        Strong::assertInstanceOf($node);

        $content = $childRenderer->renderNodes($node->children());

        if ($this->config->get('commonmark/use_asterisk')) {
            return "**{$content}**";
        }

        if ($this->config->get('commonmark/use_underscore')) {
            return "__{$content}__";
        }

        $openingDelimiter = $node->getOpeningDelimiter();
        $closingDelimiter = $node->getClosingDelimiter();

        return "$openingDelimiter{$content}$closingDelimiter";
    }
}
