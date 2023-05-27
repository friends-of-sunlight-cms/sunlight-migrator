<?php

use Phinx\Migration\AbstractMigration;

class UpdateUsersData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_user');

        // remove old activations
        $this->query("TRUNCATE TABLE " . $this->getAdapter()->getAdapterTableName('_user_activation'));

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('publicname', 'NULL')
            ->where(['publicname' => ''])
            ->execute();

        // convert old pass
        $this->query("UPDATE " . $prefixedTableName . " SET `password`=CONCAT('md5_legacy:0:', `salt`, ':', `password`)");
        $this->table('_user')->removeColumn('salt')->update();


        //--- MOVE USER WITH ID=0

        // get data from user with id=0
        $oldAdminBuilder = $this->getQueryBuilder()
            ->select(['*'])
            ->from($prefixedTableName)
            ->where(['id' => 0])->execute();
        $oldAdminData = $oldAdminBuilder->fetchAssoc();

        // remove id
        unset($oldAdminData['id']);

        // remove user
        $this->getQueryBuilder()
            ->delete($prefixedTableName)
            ->where(['id' => 0])
            ->execute();

        // insert user as new row
        $builder = $this->getQueryBuilder();
        $st = $builder
            ->insert(array_keys($oldAdminData))
            ->values($oldAdminData)
            ->into($prefixedTableName)
            ->execute();

        // get new ID
        $newAdminId = $st->lastInsertId('_user', 'id');

        // update user id in other tables
        $this->getQueryBuilder()->update($this->getAdapter()->getAdapterTableName('_pm'))
            ->set('sender', $newAdminId)
            ->where(['sender' => 0])
            ->execute();

        $this->getQueryBuilder()->update($this->getAdapter()->getAdapterTableName('_pm'))
            ->set('receiver', $newAdminId)
            ->where(['receiver' => 0])
            ->execute();

        $this->getQueryBuilder()->update($this->getAdapter()->getAdapterTableName('_post'))
            ->set('author', $newAdminId)
            ->where(['author' => 0])
            ->execute();

        $this->getQueryBuilder()->update($this->getAdapter()->getAdapterTableName('_article'))
            ->set('author', $newAdminId)
            ->where(['author' => 0])->execute();

        $this->getQueryBuilder()->update($this->getAdapter()->getAdapterTableName('_poll'))
            ->set('author', $newAdminId)
            ->where(['author' => 0])
            ->execute();
    }
}
