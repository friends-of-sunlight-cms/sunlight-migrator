<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateIplogTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_iplog');

        $table
            ->changeColumn('ip', 'string', ['limit' => 45] + $collation)
            ->changeColumn('type', 'integer', ['limit' => 11])
            ->changeColumn('time', 'biginteger', ['limit' => MysqlAdapter::INT_BIG])
            ->changeColumn('var', 'integer', ['default' => 0]);

        $table->update();
    }
}
