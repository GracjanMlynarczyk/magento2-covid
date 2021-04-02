<?php

namespace Ghratzoo\Covid\Console\Command;

use Ghratzoo\Covid\Api\Data\CovidInterfaceFactory;
use Ghratzoo\Covid\Service\CovidManagement;
use Ghratzoo\Covid\Service\CovidRepository;
use GuzzleHttp\Client;
use Magento\Framework\Exception\AlreadyExistsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CovidUpdate extends Command
{

    /**
     * @var CovidRepository
     */
    private CovidRepository $covidRepository;

    /**
     * @var CovidManagement
     */
    private CovidManagement $covidManagement;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var CovidInterfaceFactory
     */
    private CovidInterfaceFactory $covidInterface;

    /**
     * CovidInit constructor.
     * @param CovidRepository $covidRepository
     * @param CovidManagement $covidManagement
     * @param Client $client
     * @param CovidInterfaceFactory $covidInterface
     * @param string|null $name
     */
    public function __construct(
        CovidRepository $covidRepository,
        CovidManagement $covidManagement,
        Client $client,
        CovidInterfaceFactory $covidInterface,
        string $name = null
    ) {
        $this->covidManagement = $covidManagement;
        $this->covidRepository = $covidRepository;
        $this->client = $client;
        $this->covidInterface = $covidInterface;
        parent::__construct($name);
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this->setName('covid:update');
        $this->setDescription('Update covid data');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln("Covid update start :)");

        $data = json_decode($this->client->get('https://api.covid19api.com/summary')->getBody()->getContents());

        $poland = array_values(array_filter($data->Countries, function ($country) {
            return $country->Country === "Poland";
        }));

        $covid = $this->covidRepository->getTodayCovid();

        if ($covid === null)
        {
            $dateTime = new \DateTime('now');
            $dateTime->setTime(0,0, 0, 0);
            $covid = $this->covidInterface->create();
            $covid->setDate($dateTime->format('Y-m-d H:i:s'));
        }

        $covid->setConfirmed($poland[0]->TotalConfirmed);
        $covid->setDeaths($poland[0]->TotalDeaths);
        $covid->setRecovered($poland[0]->TotalRecovered);
        $this->covidManagement->save($covid);

        $output->writeln("Covid update stop :)");
    }
}
