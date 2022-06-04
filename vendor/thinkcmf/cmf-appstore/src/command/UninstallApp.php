<?php

namespace app\admin\command;

use app\admin\logic\AppLogic;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class UninstallApp extends Command
{
    protected function configure()
    {
        $this->setName('uninstall:app')
            ->addArgument('name', Argument::REQUIRED, "The app name")
            ->setDescription('Uninstall a ThinkCMF app');
    }

    protected function execute(Input $input, Output $output)
    {
        $name = $input->getArgument('name');
        $output->confirm($input,'Are you sure to uninstall this app?');
        $result = AppLogic::uninstall($name);

        if ($result === true) {
            $output->writeln("Uninstall successful!");
        } else if ($result === false) {
            $output->writeln("<error>Uninstall failed!</error>");
        } else {
            $output->writeln("<error>$result</error>");
        }

    }


}
