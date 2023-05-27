<?php

use Phinx\Migration\AbstractMigration;

class UpdateArticlesData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_article');

        $builder = $this->getQueryBuilder();
        $concat = $builder->func()->concat([
            '<p>',
            'perex' => 'literal',
            '</p>'
        ]);

        $builder->update($prefixedTableName)
            ->set('perex', $concat)
            ->execute();
    }
}
