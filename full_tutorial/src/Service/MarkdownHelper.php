<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 05/05/2018
 * Time: 21:43
 */

namespace App\Service;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Michelf\MarkdownInterface;
//use Psr\Log\LoggerInterface;
use App\Helper\LoggerTrait;

class MarkdownHelper
{
    /**
     * @var AdapterInterface
     */
    private $cache;

    /**
     * @var MarkdownInterface
     */
    private $markdown;

    /**
     * @var bool
     */
    private $isDebug;

    use LoggerTrait;

    /**
     * MarkdownHelper constructor.
     */
    public function __construct(AdapterInterface $cache, MarkdownInterface $markdown, bool $isDebug)
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->isDebug = $isDebug;
    }

    public function parse(string $source): string
    {

        // skip caching entirely in debug
        if ($this->isDebug) {
            $this->logInfo('Skip caching because we\'re debuging');
            return $this->markdown->transform($source);
        }

        $item = $this->cache->getItem('markdown_'.md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }
        return $item->get();
    }
}