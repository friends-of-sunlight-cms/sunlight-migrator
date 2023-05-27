<?php

use Phinx\Migration\AbstractMigration;

class UpdateShoutBoxTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_shoutbox');

        $table
            ->changeColumn('title', 'string', ['limit' => 64] + $collation)
            ->changeColumn('locked', 'boolean', ['default' => false])
            ->changeColumn('public', 'boolean', ['default' => true]);

        $table->update();
    }
}
