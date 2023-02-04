<?php

namespace App\Command;

use App\Entity\Anime;
use App\Entity\Studio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'ImportDataCommand',
    description: 'Add a short description for your command',
)]
class ImportDataCommand extends Command
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        //animes
        for ($i = 15; $i <= 35; $i++){
            sleep(0.5);
            try {

            $json =  file_get_contents("https://api.jikan.moe/v4/anime/{$i}");
            $data = json_decode($json, true);
            $data = $data['data'];

                $anime = new Anime();
                $anime->setTitle( $data['title']);
                $anime->setImage($data['images']['jpg']['image_url']);
                $anime->setGenres($data['genres']);
                $anime->setStudio(new Studio('title'));
                $this->entityManager->persist($anime);
            } catch (\Exception $e){
                //error
            }

            }


        $this->entityManager->flush();

        /*
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.example.com/data');
        $data = $response->toArray();*/

        $output->writeln('Data imported successfully.');
        return Command::SUCCESS;
    }
}
