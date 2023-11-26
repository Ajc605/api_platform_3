<?php

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
//$isUnitTestsuiteBeingRun = in_array('--testsuite=Unit', $argv);

//if ($isUnitTestsuiteBeingRun === false) {
    $kernelClass = $_ENV['KERNEL_CLASS'];
$kernel = new $kernelClass('test', true);
$kernel->boot();

$application = new Application($kernel);
$application->setAutoExit(false);

updateDoctrineSchema($application);
loadDatabaseFixtures($application);

$kernel->shutdown();
//}

function updateDoctrineSchema(Application $application): void
{
    $output = new BufferedOutput();
    $status = $application->run(
        new ArrayInput([
            'command' => 'doctrine:schema:update',
            '--force' => true,
            '--no-interaction' => true,
        ]),
        $output
    );

    if ($status !== 0) {
        echo $output->fetch();
        throw new \Exception('Failed to update Doctrine Schema.');
    }
}

function loadDatabaseFixtures(Application $application): void
{
    $output = new BufferedOutput();
    $status = $application->run(
        new ArrayInput([
            'command' => 'hautelook:fixtures:load',
            '--no-bundles' => true,
            '--purge-with-truncate' => true,
            '--no-interaction' => true,
        ]),
        $output
    );

    if ($status !== 0) {
        echo $output->fetch();
        throw new \Exception('Failed to load fixtures into database.');
    }
}
