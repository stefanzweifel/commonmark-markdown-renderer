<?php

declare(strict_types=1);

namespace Wnx\CommonmarkMarkdownRenderer\Renderer\Inline;

use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

final class EmphasisRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    /** @psalm-readonly-allow-private-mutation */
    private ConfigurationInterface $config;

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }

    /**
     * @param Emphasis $node
     *
     * {@inheritDoc}
     *
     * @psalm-suppress MoreSpecificImplementedParamType
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        Emphasis::assertInstanceOf($node);

        $content = $childRenderer->renderNodes($node->children());

        if ($this->config->get("commonmark/use_asterisk")) {
            return "*{$content}*";
        }

        return "_{$content}_";
    }
}
