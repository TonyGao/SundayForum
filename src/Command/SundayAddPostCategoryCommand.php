<?php

namespace App\Command;

use App\Entity\PostCategory;
use App\Repository\PostCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Question\Question;

#[AsCommand(
    name: 'sunday:add-post-category',
    description: 'Add a category for post',
)]
class SundayAddPostCategoryCommand extends Command
{
    private $em;
    private $categories;

    public function __construct(EntityManagerInterface $em, PostCategoryRepository $categories)
    {
      parent::__construct();
      $this->em = $em;
      $this->categories = $categories;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('categoryName', InputArgument::OPTIONAL, 'Category Name')
            ->addArgument('parentCategoryName', InputArgument::OPTIONAL, 'parent category name or root')
        ;
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        if (null !== $input->getArgument('categoryName') && null !== $input->getArgument('parentCategoryName')) {
            return;
        }

        $this->io->title('Add Post Category Command Interactive Wizard');
        $this->io->text([
            'If you prefer to not use this interactive wizard, privide the',
            'arguemnts required by this command as follows:',
            '',
            ' $ php bin/console sunday:add-post-category categoryName parentCategoryName(or root)',
            '',
            'Now we\'ll ask you all missing command arguments.',
        ]);

        // Ask for the username if it's not defined
        $categoryName = $input->getArgument('categoryName');
        if (null !== $categoryName) {
            $this->io->text(' > <info>Category Name</info>: '.$categoryName);
        } else {
            $categoryName = $this->io->ask('Cateogry Name', null);
            if (empty($categoryName)) {
              throw new InvalidArgumentException('The category name can not be empty.');
            }

            // check if the category name is already exist.
            $this->validateCategoryName($categoryName);
            $input->setArgument('categoryName', $categoryName);
        }

        // Ask for the parentCategoryName if it's not defined
        $parentCategoryName = $input->getArgument('parentCategoryName');
        if (null !== $parentCategoryName) {
            $this->io->text(' > <info>Parent Category Name</info>: '.$parentCategoryName);
        } else {
            // autocompletion question
            $cats = $this->categories->findAllTitletoArray();
            $question = new Question('Please enter the parent category for you just created category');
            $question->setAutocompleterValues($cats);
            $password = $this->io->askQuestion($question);
            $input->setArgument('password', $password);
        }
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

        return Command::SUCCESS;
    }

    private function validateCategoryName($categoryName): void
    {
      $isExist = $this->categories->findOneBy(['title' => $categoryName]);

      if (null !== $isExist) {
        throw new RuntimeException(sprintf('There is already a same name for post category "%s", try another one.', $categoryName));
      }
    }
}
