<?php

use Phinx\Migration\AbstractMigration;

class UpdatePostsData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_post');

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('subject', '')
            ->where(['subject' => ''])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('subject', '')
            ->where(['xhome' => -1])
            ->whereNotInList('type', [5, 6])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('guest', '')
            ->where(['guest' => 'Anonym'])
            ->execute();
    }
}
