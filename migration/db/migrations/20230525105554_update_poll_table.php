<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdatePollTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_poll');

        $table
            ->changeColumn('question', 'string', ['limit' => 96] + $collation)
            ->changeColumn('answers', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->changeColumn('locked', 'boolean', ['default' => false])
            ->changeColumn('votes', 'string', ['limit' => 255] + $collation);

        $table->update();
    }
}
