<?php
/**
 * Created by PhpStorm.
 * User: Pierre
 * Date: 09/05/2018
 * Time: 21:21
 */

namespace App\Helper;

use Psr\Log\LoggerInterface;

trait LoggerTrait {
    /**
     * @var LoggerInterface|null
     */
    private $logger;
    /**
     * @required
     */
    public function setLogger(LoggerInterface $markdownLogger)
    {
        $this->logger = $markdownLogger;
    }

    /**
     * use: $this->logInfo('Beaming a message to Slack!', [
    'message' => 'TUTUTUTU'
    ]);
     */
    private function logInfo(string $message, array $context = [])
    {

        if ($this->logger) {
            $this->logger->info($message, $context);
        }
    }
}