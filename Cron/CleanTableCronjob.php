<?php


namespace Ghratzoo\Covid\Cron;


use Psr\Log\LoggerInterface;

class CleanTableCronjob
{

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * CleanTableCronjob constructor.
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
        $this->logger->info('Cron Works');
    }
}
