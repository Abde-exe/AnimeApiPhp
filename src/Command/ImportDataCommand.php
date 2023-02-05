<?php

namespace App\Command;

use App\Entity\Anime;
use App\Entity\Character;
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


        //studios
        $studioArray =array();

        $json =  file_get_contents("https://api.jikan.moe/v4/producers/?limit=5");
        $data = json_decode($json, true);
        $studios = $data['data'];
        foreach ($studios as $stud) {
            $studio = new Studio();
            $studio->setName($stud['titles'][0]['title']);
           array_push($studioArray, $studio);
            $this->entityManager->persist($studio);
        }

        //animes
        $animeArray = array();
        for ($i = 1; $i <= 20; $i++) {
            try {
                sleep(1);
            $json =  file_get_contents("https://api.jikan.moe/v4/anime/{$i}");
            $data = json_decode($json, true);

            if(isset($data['error'])){
                error_log("Error retrieving anime with id {$i}: {$data['error']}");
                continue;
            }
            $data = $data['data'];

                $anime = new Anime();
                $anime->setTitle( $data['title']);
                $anime->setImage($data['images']['jpg']['image_url']);
                $anime->setGenres($data['genres'][0]['name']);
                $anime->setStudio($studioArray[$i % 5]);
                //array_push($animeArray, $anime);
                sleep(1);
                $json2 =  file_get_contents("https://api.jikan.moe/v4/anime/{$i}/characters");
                $data2 = json_decode($json2, true);
                if(isset($data2['error'])){
                    error_log("Error retrieving character for anime with id {$i}: {$data2['error']}");
                    continue;
                }
                $dataChar = $data2["data"];
                foreach ($dataChar as $char){
                    $character = new Character();
                    $character->setName($char["character"]["name"]);
                    $character->setImg($char["character"]["images"]["jpg"]["image_url"]);
                    $character->setAbout("");
                    $anime->addCharacter($character);
                    $this->entityManager->persist($character);
                }

                $this->entityManager->persist($anime);
            } catch (\Exception $e){
                error_log($e->getMessage());
            }
            }
        /*//characters
        $characterArray = array();
        for ($i = 1; $i <= 20; $i++) {
            try {
                sleep(1);
            $json =  file_get_contents("https://api.jikan.moe/v4/anime/{$i}/characters");
            $data = json_decode($json, true);
            if(isset($data['error'])){
                error_log("Error retrieving characters of anim with id {$i}: {$data['error']}");
                continue;
            }
            $characters = $data['data'];

                $character = new Anime();
                $character->setTitle( $data['title']);
                $character->setImage($data['images']['jpg']['image_url']);
                $character->setGenres($data['genres'][0]['name']);
                $character->setStudio($studioArray[$i % 5]);
                array_push($characterArray, $character);
                $this->entityManager->persist($character);
            } catch (\Exception $e){
                error_log($e->getMessage());
            }
            }*/



        $this->entityManager->flush();

        /*
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.example.com/data');
        $data = $response->toArray();*/

        $output->writeln('Data imported successfully.');
        return Command::SUCCESS;
    }
}
