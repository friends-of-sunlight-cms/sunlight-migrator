<?php

namespace Sunlight\Migrator;

use Phinx;

class MigrationRunner
{
    static function runMigrations(): bool
    {

        $app = new Phinx\Console\PhinxApplication();
        $wrap = new Phinx\Wrapper\TextWrapper($app);

        $wrap->setOption('configuration', __DIR__ . '/../phinx.yaml');
        $wrap->getMigrate();
        return $wrap->getExitCode() === 0;
    }
}



