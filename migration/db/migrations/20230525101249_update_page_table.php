<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdatePageTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_page');

        $table
            ->renameColumn('intersectionperex', 'perex')
            ->renameColumn('autotitle', 'show_heading')
            ->renameColumn('intersection', 'node_parent')
            ->changeColumn('title', 'string', ['limit' => 255] + $collation)
            ->addColumn('heading', 'string', ['limit' => 255, 'default' => '', 'after' => 'title'] + $collation)
            ->changeColumn('slug', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->addColumn('slug_abs', 'boolean', ['default' => false, 'after' => 'slug'])
            ->changeColumn('description', 'string', ['limit' => 255, 'default' => ''] + $collation)
            ->changeColumn('node_parent', 'integer', ['null' => true])
            ->addColumn('node_level', 'integer', ['default' => 0, 'after' => 'node_parent'])
            ->addColumn('node_depth', 'integer', ['default' => 0, 'after' => 'node_level'])
            ->changeColumn('perex', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->changeColumn('ord', 'integer', ['default' => 0])
            ->changeColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG] + $collation)
            ->changeColumn('visible', 'boolean', ['default' => true])
            ->changeColumn('public', 'boolean', ['default' => true])
            ->addColumn('level_inherit', 'boolean', ['default' => false, 'after' => 'level'])
            ->changeColumn('show_heading', 'boolean', ['default' => true])
            ->changeColumn('events', 'string', ['null' => true] + $collation)
            ->addColumn('link_new_window', 'boolean', ['default' => false, 'after' => 'events'])
            ->addColumn('link_url', 'string', ['null' => true, 'after' => 'link_new_window'] + $collation)
            ->addColumn('layout', 'string', ['null' => true, 'after' => 'link_url'] + $collation)
            ->addColumn('layout_inherit', 'boolean', ['default' => false, 'after' => 'layout'])
            ->changeColumn('var1', 'integer', ['null' => true])
            ->changeColumn('var2', 'integer', ['null' => true])
            ->changeColumn('var3', 'integer', ['null' => true])
            ->changeColumn('var4', 'integer', ['null' => true])
            ->renameColumn('title_seo', 'slug')
            ->removeColumn('keywords');

        $table->removeIndex(['slug'])
            ->addIndex(['show_heading'])
            ->addIndex(['slug_abs'])
            ->addIndex(['node_parent'])
            ->addIndex('slug', ['limit' => 16]);


        $table->update();
    }
}
