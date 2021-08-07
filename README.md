# Render Markdown AST back to Markdown.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wnx/commonmark-markdown-renderer.svg?style=flat-square)](https://packagist.org/packages/wnx/commonmark-markdown-renderer)
[![Tests](https://github.com/stefanzweifel/commonmark-markdown-renderer/actions/workflows/run-tests.yml/badge.svg)](https://github.com/stefanzweifel/commonmark-markdown-renderer/actions/workflows/run-tests.yml)
[![Check & fix styling](https://github.com/stefanzweifel/commonmark-markdown-renderer/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/stefanzweifel/commonmark-markdown-renderer/actions/workflows/php-cs-fixer.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/wnx/commonmark-markdown-renderer.svg?style=flat-square)](https://packagist.org/packages/wnx/commonmark-markdown-renderer)

Render a league/commonmark AST back to Markdown.

**Note**: Markdown knows alternate syntaxes for the same elements (heading, emphasis, unordered lists, horizontal rules). Therefore input and output Markdown may differ.

## Installation

You can install the package via composer:

```bash
composer require wnx/commonmark-markdown-renderer
```

## Usage

```php
use League\CommonMark\Environment\Environment;
use League\CommonMark\Parser\MarkdownParser;
use Wnx\CommonmarkMarkdownRenderer\MarkdownRendererExtension;
use Wnx\CommonmarkMarkdownRenderer\Renderer\MarkdownRenderer;

$environment = new Environment($config);
$environment->addExtension(new MarkdownRendererExtension());

$markdownParser = new MarkdownParser($environment);
$markdownRenderer = new MarkdownRenderer($environment);

$markdown = "**Hello World!**";

$documentAST = $markdownParser->parse($markdown);

// Manipulate AST in your script (append, prepend or replace nodes)

$markdown = $markdownRenderer->renderDocument($documentAST);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Stefan Zweifel](https://github.com/stefanzweifel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
