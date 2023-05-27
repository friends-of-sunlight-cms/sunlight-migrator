<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdatePmTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_pm');

        $table
            ->changeColumn('sender_readtime', 'biginteger', ['limit' => MysqlAdapter::INT_BIG])
            ->changeColumn('receiver_readtime', 'biginteger', ['limit' => MysqlAdapter::INT_BIG])
            ->changeColumn('update_time', 'biginteger', ['limit' => MysqlAdapter::INT_BIG]);

        $table->update();
    }
}
