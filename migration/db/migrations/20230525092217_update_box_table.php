<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateBoxTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_box');

        $table
            ->renameColumn('column', 'slot')
            ->changeColumn('ord', 'integer', ['default' => 0])
            ->changeColumn('title', 'string', ['limit' => 255, 'default' => ''] + $collation)
            ->changeColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->changeColumn('visible', 'boolean', ['default' => true])
            ->changeColumn('public', 'boolean', ['default' => true])
            ->addColumn('level', 'integer', ['default' => 0, 'after' => 'public'])
            ->addColumn('template', 'string', ['limit' => 255, 'after' => 'level'] + $collation)
            ->addColumn('layout', 'string', ['limit' => 255, 'after' => 'template'] + $collation)
            ->changeColumn('slot', 'string', ['limit' => 64, 'after' => 'layout'] + $collation)
            ->addColumn('page_ids', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM, 'null' => true, 'after' => 'slot'] + $collation)
            ->addColumn('page_children', 'boolean', ['default' => false, 'after' => 'page_ids'])
            ->changeColumn('class', 'string', ['null' => true] + $collation);

        $table
            ->addIndex(['slot'])
            ->addIndex(['level'])
            ->addIndex(['template'], ['limit' => 191])
            ->addIndex(['layout'], ['limit' => 191]);

        $table->update();
    }
}
