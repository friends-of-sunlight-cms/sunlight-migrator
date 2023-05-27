<?php

use Phinx\Migration\AbstractMigration;

class UpdateGalleryImageTable extends AbstractMigration
{
    public function change()
    {
        $collation = ['collation' => 'utf8mb4_unicode_ci'];

        $table = $this->table('_gallery_image');

        $table
            ->changeColumn('ord', 'integer', ['default' => 0])
            ->changeColumn('title', 'string', ['default' => ''] + $collation)
            ->changeColumn('prev', 'string', ['default' => ''] + $collation)
            ->changeColumn('full', 'string', ['default' => ''] + $collation);

        $table->update();
    }
}
