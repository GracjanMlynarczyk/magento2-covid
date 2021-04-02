<?php

namespace Ghratzoo\Covid\Cron;

use Psr\Log\LoggerInterface;

class UpdateCron
{

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UpdateCron constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Cronjob Description
     *
     * @return void
     */
    public function execute(): void
    {
        $this->logger->info('Covid Update Start');

        shell_exec('php bin/magento covid:update');

        $this->logger->info('Covid Update Stop');
    }
}
