<?php

use Phinx\Migration\AbstractMigration;

class UpdateUserGroupTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_user_group');

        $table
            ->renameColumn('adminintersection', 'admingroup')
            ->renameColumn('adminfman', 'fileaccess')
            ->renameColumn('adminfmanlimit', 'fileglobalaccess')
            ->renameColumn('adminfmanplus', 'fileadminaccess')
            ->renameColumn('adminneedconfirm', 'adminautoconfirm')
            ->renameColumn('selfdestruction', 'selfremove')
            ->changeColumn('title', 'string', ['limit' => 128] + $collation)
            ->changeColumn('descr', 'string', ['limit' => 255, 'default' => ''] + $collation)
            ->changeColumn('level', 'integer', ['default' => 0])
            ->changeColumn('icon', 'string', ['limit' => 16, 'default' => ''] + $collation)
            ->changeColumn('blocked', 'boolean', ['default' => false])
            ->changeColumn('reglist', 'boolean', ['default' => false])
            ->changeColumn('administration', 'boolean', ['default' => false])
            ->changeColumn('adminsettings', 'boolean', ['default' => false])
            ->addColumn('adminplugins', 'boolean', ['default' => false, 'after' => 'adminsettings'])
            ->changeColumn('adminusers', 'boolean', ['default' => false])
            ->changeColumn('admingroups', 'boolean', ['default' => false])
            ->changeColumn('admincontent', 'boolean', ['default' => false])
            ->addColumn('adminother', 'boolean', ['default' => false, 'after' => 'admincontent'])
            ->addColumn('adminpages', 'boolean', ['default' => false, 'after' => 'adminother'])
            ->changeColumn('adminsection', 'boolean', ['default' => false])
            ->changeColumn('admincategory', 'boolean', ['default' => false])
            ->changeColumn('adminbook', 'boolean', ['default' => false])
            ->changeColumn('adminseparator', 'boolean', ['default' => false])
            ->changeColumn('admingallery', 'boolean', ['default' => false])
            ->changeColumn('adminlink', 'boolean', ['default' => false])
            ->changeColumn('admingroup', 'boolean', ['default' => false])
            ->changeColumn('adminforum', 'boolean', ['default' => false])
            ->changeColumn('adminpluginpage', 'boolean', ['default' => false])
            ->changeColumn('adminart', 'boolean', ['default' => false])
            ->changeColumn('adminallart', 'boolean', ['default' => false])
            ->changeColumn('adminchangeartauthor', 'boolean', ['default' => false])
            ->changeColumn('adminconfirm', 'boolean', ['default' => false])
            ->changeColumn('adminautoconfirm', 'boolean', ['default' => false, 'after' => 'adminconfirm'])
            ->changeColumn('adminpoll', 'boolean', ['default' => false])
            ->changeColumn('adminpollall', 'boolean', ['default' => false])
            ->changeColumn('adminsbox', 'boolean', ['default' => false])
            ->changeColumn('adminbox', 'boolean', ['default' => false])
            ->changeColumn('fileaccess', 'boolean', ['default' => false, 'after' => 'adminbox'])
            ->changeColumn('fileglobalaccess', 'boolean', ['default' => false, 'after' => 'fileaccess'])
            ->changeColumn('fileadminaccess', 'boolean', ['default' => false, 'after' => 'fileglobalaccess'])
            ->addColumn('adminhcm', 'string', ['default' => '', 'after' => 'fileadminaccess'])
            ->changeColumn('adminhcmphp', 'boolean', ['default' => false])
            ->changeColumn('adminbackup', 'boolean', ['default' => false])
            ->changeColumn('adminmassemail', 'boolean', ['default' => false])
            ->changeColumn('adminposts', 'boolean', ['default' => false])
            ->changeColumn('changeusername', 'boolean', ['default' => false])
            ->changeColumn('postcomments', 'boolean', ['default' => false])
            ->changeColumn('unlimitedpostaccess', 'boolean', ['default' => false])
            ->changeColumn('locktopics', 'boolean', ['default' => false])
            ->changeColumn('stickytopics', 'boolean', ['default' => false])
            ->changeColumn('movetopics', 'boolean', ['default' => false])
            ->changeColumn('artrate', 'boolean', ['default' => false])
            ->changeColumn('pollvote', 'boolean', ['default' => false])
            ->changeColumn('selfremove', 'boolean', ['default' => false])
            ->removeColumn('adminrestore');

        $table->update();
    }
}
