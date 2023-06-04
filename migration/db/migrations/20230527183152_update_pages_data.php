<?php

use Phinx\Migration\AbstractMigration;

class UpdatePagesData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_page');

        $this->query("UPDATE " . $prefixedTableName . " SET `node_parent`=NULL WHERE `node_parent`=0 OR `node_parent`=-1");

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('var2', 0)
            ->where(['type' => 7])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('level_inherit', 1)
            ->where(['level' => 0])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('layout_inherit', 1)
            ->execute();
    }
}
