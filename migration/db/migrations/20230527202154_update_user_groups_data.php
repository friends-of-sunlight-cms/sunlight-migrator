<?php

use Phinx\Migration\AbstractMigration;

class UpdateUserGroupsData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_user_group');

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('adminpages', 1)
            ->where([
                'OR' => [
                    'id' => 1,
                    'adminsection' => 1,
                    'admincategory' => 1,
                    'adminbook' => 1,
                    'adminseparator' => 1,
                    'admingallery' => 1,
                    'adminlink' => 1,
                    'admingroup' => 1,
                    'adminforum' => 1,
                    'adminpluginpage' => 1,
                ],
            ])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('fileglobalaccess', -1)
            ->where(['fileglobalaccess' => 0])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('fileglobalaccess', 0)
            ->where(['fileglobalaccess' => 1])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('fileglobalaccess', 1)
            ->where(['fileglobalaccess' => -1])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('adminautoconfirm', -1)
            ->where(['fileglobalaccess' => 0])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('adminautoconfirm', 0)
            ->where(['fileglobalaccess' => 1])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('adminautoconfirm', 1)
            ->where(['fileglobalaccess' => -1])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set([
                'blocked' => 0,
                'reglist' => 0,
                'administration' => 0,
                'adminsettings' => 0,
                'adminplugins' => 0,
                'adminusers' => 0,
                'admingroups' => 0,
                'admincontent' => 0,
                'adminother' => 0,
                'adminpages' => 0,
                'adminsection' => 0,
                'admincategory' => 0,
                'adminbook' => 0,
                'adminseparator' => 0,
                'admingallery' => 0,
                'adminlink' => 0,
                'admingroup' => 0,
                'adminforum' => 0,
                'adminpluginpage' => 0,
                'adminart' => 0,
                'adminallart' => 0,
                'adminchangeartauthor' => 0,
                'adminconfirm' => 0,
                'adminautoconfirm' => 0,
                'adminpoll' => 0,
                'adminpollall' => 0,
                'adminsbox' => 0,
                'adminbox' => 0,
                'fileaccess' => 0,
                'fileglobalaccess' => 0,
                'fileadminaccess' => 0,
                'adminhcm' => '',
                'adminhcmphp' => 0,
                'adminbackup' => 0,
                'adminmassemail' => 0,
                'adminposts' => 0,
                'changeusername' => 0,
                'postcomments' => 1,
                'unlimitedpostaccess' => 0,
                'locktopics' => 0,
                'stickytopics' => 0,
                'movetopics' => 0,
                'artrate' => 1,
                'pollvote' => 1,
                'selfremove' => 0,
            ])
            ->where(['id' => 2])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set([
                'adminhcm' => '*',
                'adminplugins' => 1,
            ])
            ->where(['id' => 1])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('adminother', 1)
            ->where([
                'OR' => [
                    'id' => 1,
                    'adminbackup' => 1,
                    'adminmassemail' => 1,
                ],
            ])
            ->execute();
    }
}
