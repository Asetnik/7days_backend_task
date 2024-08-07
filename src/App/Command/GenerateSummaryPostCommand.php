<?php

namespace App\Command;

use App\Service\PostService;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSummaryPostCommand extends Command
{
    protected static $defaultName = 'app:generate-summary-post';
    protected static $defaultDescription = 'Run app:generate-summary-post';

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
        $title = 'Summary ' . (new \DateTime('now'))->format('Y-m-d');
        $content = $this->loremIpsum->paragraphs(1);

        $this->postService->create($title, $content);

        $output->writeln('A summary post has been generated.');

        return Command::SUCCESS;
    }
}
