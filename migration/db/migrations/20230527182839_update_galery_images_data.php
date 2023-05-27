<?php

use Phinx\Migration\AbstractMigration;

class UpdateGaleryImagesData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_gallery_image');
        $this->query("UPDATE " . $prefixedTableName . " SET full = CONCAT('images/galleries/', SUBSTRING(full, 20)) WHERE prev = '' AND SUBSTRING(full, 1, 19) = 'pictures/galleries/'");
    }
}
