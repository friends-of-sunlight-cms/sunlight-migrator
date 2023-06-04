<?php

use Phinx\Migration\AbstractMigration;

class UpdateBoxData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_box');

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('template', 'default')
            ->set('layout', 'default')
            ->set('slot', 'right')
            ->execute();
    }
}
