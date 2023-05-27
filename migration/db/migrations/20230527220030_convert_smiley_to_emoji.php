<?php

use Phinx\Migration\AbstractMigration;

class ConvertSmileyToEmoji extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_post');

        $this->query(
            "SET collation_connection = 'utf8mb4_unicode_ci';
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*1*', '🙂');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*2*', '😋');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*3*', '😄');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*4*', '😲');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*5*', '😁');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*6*', '🤬');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*7*', '😞');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*8*', '🤨');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*9*', '🤤');
                UPDATE " . $prefixedTableName . " SET text = replace(text, '*10*', '😎');"
        );
    }
}
