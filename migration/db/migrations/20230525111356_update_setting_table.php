<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateSettingTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_setting');

        $table
            ->changeColumn('var', 'string', ['limit' => 24] + $collation)
            ->changeColumn('val', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->addColumn('preload', 'boolean', ['default' => false])
            ->addColumn('web', 'boolean')
            ->addColumn('admin', 'boolean');

        $table->addIndex(['preload']);
        $table->addIndex(['web']);
        $table->addIndex(['admin']);

        $table->update();
    }
}
