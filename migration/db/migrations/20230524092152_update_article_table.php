<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateArticleTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_article');

        $table
            ->renameColumn('title_seo', 'slug')
            ->renameColumn('readed', 'readnum')
            ->changeColumn('title', 'string', ['limit' => 255] + $collation)
            ->changeColumn('slug', 'string', $collation)
            ->changeColumn('description', 'string', ['limit' => 255, 'default' => ''] + $collation)
            ->changeColumn('perex', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM] + $collation)
            ->changeColumn('picture_uid', 'string', ['limit' => 32, 'null' => true] + $collation)
            ->changeColumn('content', 'text', ['limit' => MysqlAdapter::TEXT_LONG,] + $collation)
            ->changeColumn('home2', 'integer', ['default' => -1])
            ->changeColumn('home3', 'integer', ['default' => -1])
            ->changeColumn('time', 'biginteger', ['limit' => MysqlAdapter::INT_BIG])
            ->changeColumn('visible', 'boolean', ['default' => true])
            ->changeColumn('public', 'boolean', ['default' => true])
            ->changeColumn('comments', 'boolean', ['default' => true])
            ->changeColumn('commentslocked', 'boolean', ['default' => false])
            ->changeColumn('confirmed', 'boolean', ['default' => false])
            ->changeColumn('showinfo', 'boolean', ['default' => true])
            ->changeColumn('readnum', 'integer', ['default' => 0])
            ->changeColumn('rateon', 'boolean', ['default' => true])
            ->changeColumn('ratenum', 'integer', ['default' => 0])
            ->changeColumn('ratesum', 'integer', ['default' => 0])
            ->removeColumn('keywords')
            ->removeColumn('infobox');

        $table
            ->removeIndex(['slug'])
            ->addIndex(['slug'], ['limit' => 191]);

        $table->update();
    }
}
