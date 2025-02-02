<?php

namespace App\Command;

use App\Service\PostService;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateRandomPostCommand extends Command
{
    protected static $defaultName = 'app:generate-random-post';
    protected static $defaultDescription = 'Run app:generate-random-post';

    private LoremIpsum $loremIpsum;
    private PostService $postService;

    public function __construct(LoremIpsum $loremIpsum, PostService $postService, string $name = null)
    {
        parent::__construct($name);
        $this->loremIpsum = $loremIpsum;
        $this->postService = $postService;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = $this->loremIpsum->words(mt_rand(4, 6));
        $content = $this->loremIpsum->paragraphs(2);

        $this->postService->create($title, $content);

        $output->writeln('A random post has been generated.');

        return Command::SUCCESS;
    }
}
