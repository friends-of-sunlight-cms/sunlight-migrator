<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdatePostTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_post');

        $table
            ->changeColumn('xhome', 'integer', ['default' => -1])
            ->changeColumn('subject', 'string', ['limit' => 48, 'default' => ''] + $collation)
            ->changeColumn('text', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->changeColumn('author', 'integer', ['default' => -1])
            ->changeColumn('guest', 'string', ['limit' => 24, 'default' => ''] + $collation)
            ->changeColumn('time', 'biginteger', ['limit' => MysqlAdapter::INT_BIG])
            ->changeColumn('ip', 'string', ['limit' => 45, 'default' => ''] + $collation);

        $table->update();
    }
}
