<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /**
     * @var MarkdownHelper|null
     */
    private $markdownHelper;

    /**
     * AppExtension constructor.
     */
    public function __construct(MarkdownHelper $markdownHelper)
    {
        $this->markdownHelper = $markdownHelper;
    }

    public function getFilters(): array
    {
//        is_safe => output will not be escaped through htmlentities()
        return [
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'processMarkdown']),
        ];
    }

    public function processMarkdown($value)
    {

        return $this->markdownHelper->parse($value);
    }
}
