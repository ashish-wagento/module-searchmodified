<?php
/**
 * Created by PhpStorm.
 * User: ashish
 * Date: 13/11/2018
 * Time: 10:11 AM
 */

namespace Wagento\SearchModified\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption ;
use Symfony\Component\Console\Output\OutputInterface;
use Wagento\SearchModified\Helper\Data;
class Search extends \Symfony\Component\Console\Command\Command
{
    protected $helper;

    public function __construct(Data $helper, $name = null)
    {
        parent::__construct($name);
        $this->helper = $helper;
    }

    protected function configure()
    {
        $this->setName('wagento:search')
            ->setDescription('Search Modified Files');
        $this->addOption( 'string', 'string', InputOption::VALUE_REQUIRED, 'Enter string to search e.g. AccountController', null)
           ->addOption( 'dir', 'dir', InputOption::VALUE_REQUIRED, 'Directory path e.g. app/code/local', null)
           ->addOption( 'ext', 'ext', InputOption::VALUE_REQUIRED, 'File extensions, Enter file extensions. e.g. php / For multiple file types e.g. php,phtml', null);
       return parent::configure();
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string = $input->getOption('string');
        $directory = $input->getOption('dir');
        $extensions = $input->getOption('ext');
        $result = $this->helper->searchContent($string, $directory, $extensions);
        $output->write("\n");
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $output->writeln($value);
            }
        } else{
            $output->writeln('No result found.');
        }
        return 0;
    }
}