<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateUserActivationTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_user_activation');

        $table
            ->changeColumn('code', 'string', ['limit' => 48] + $collation)
            ->changeColumn('expire', 'biginteger', ['limit' => MysqlAdapter::INT_BIG])
            ->addColumn('data', 'blob', ['limit' => MysqlAdapter::BLOB_MEDIUM])
            ->removeColumn('group')
            ->removeColumn('username')
            ->removeColumn('password')
            ->removeColumn('salt')
            ->removeColumn('massemail')
            ->removeColumn('ip')
            ->removeColumn('email');

        $table->update();
    }
}
