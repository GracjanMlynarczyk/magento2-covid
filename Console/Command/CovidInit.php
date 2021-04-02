<?php

namespace Ghratzoo\Covid\Console\Command;

use Exception;
use Ghratzoo\Covid\Api\Data\CovidInterfaceFactory;
use Ghratzoo\Covid\Service\CovidManagement;
use Ghratzoo\Covid\Service\CovidRepository;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CovidInit extends Command
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
        $this->setName('covid:init');
        $this->setDescription('Init previous covid data');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln("Covid init start :)");

        $data = json_decode($this->client->get('https://api.covid19api.com/total/country/poland')->getBody()->getContents());

        foreach ($data as $item)
        {
            if ($item->Confirmed !== 0) {
                $covid = $this->covidInterface->create();
                $covid->setConfirmed($item->Confirmed);
                $covid->setDeaths($item->Deaths);
                $covid->setRecovered($item->Recovered);
                $covid->setDate(new \DateTime($item->Date));
                $this->covidManagement->save($covid);
            }
        }

        $output->writeln("Covid init stop :)");
    }
}