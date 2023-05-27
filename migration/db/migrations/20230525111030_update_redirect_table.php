<?php

use Phinx\Migration\AbstractMigration;

class UpdateRedirectTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_redirect');

        $table
            ->changeColumn('old', 'string', $collation)
            ->changeColumn('new', 'string', $collation)
            ->addColumn('permanent', 'boolean', ['default' => false, 'after' => 'new']);

        $table->addIndex(['permanent'])
            ->removeIndexByName('old')
            ->addIndex(['old'], ['limit' => 191]);

        $table->update();
    }
}
