<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class UpdateUserTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_user');

        $table
            ->renameColumn('group', 'group_id')
            ->changeColumn('levelshift', 'boolean', ['default' => false])
            ->changeColumn('username', 'string', ['limit' => 24] + $collation)
            ->changeColumn('publicname', 'string', ['limit' => 24, 'null' => true] + $collation)
            ->changeColumn('password', 'string', $collation)
            ->changeColumn('logincounter', 'integer', ['default' => 0])
            ->changeColumn('registertime', 'biginteger', ['default' => 0])
            ->changeColumn('activitytime', 'biginteger', ['default' => 0])
            ->changeColumn('blocked', 'boolean', ['default' => false])
            ->changeColumn('massemail', 'boolean', ['default' => false])
            ->changeColumn('wysiwyg', 'boolean', ['default' => false])
            ->addColumn('public', 'boolean', ['default' => true, 'after' => 'wysiwyg'])
            ->changeColumn('language', 'string', ['limit' => 12, 'default' => ''] + $collation)
            ->changeColumn('ip', 'string', ['limit' => 45, 'default' => ''] + $collation)
            ->changeColumn('email', 'string', ['limit' => 191] + $collation)
            ->changeColumn('avatar', 'string', ['limit' => 32, 'null' => true] + $collation)
            ->changeColumn('note', 'text', ['limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => ''] + $collation)
            ->removeColumn('avatar_mode')
            ->removeColumn('web')
            ->removeColumn('skype')
            ->removeColumn('msn')
            ->removeColumn('icq')
            ->removeColumn('jabber');

        $table
            ->removeIndexByName('username')
            ->removeIndexByName('publicname')
            ->removeIndexByName('email');

        $table
            ->addIndex(['username'], ['unique' => true])
            ->addIndex(['publicname'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true]);

        $table->update();
    }
}
