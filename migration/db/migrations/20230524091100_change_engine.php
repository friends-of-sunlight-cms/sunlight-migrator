<?php

use Phinx\Migration\AbstractMigration;

class ChangeEngine extends AbstractMigration
{
    /** @var string[] oldname => newname */
    static private $tableMap = [
        'articles' => 'article',
        'boxes' => 'box',
        'groups' => 'user_group',
        'images' => 'gallery_image',
        'iplog' => 'iplog',
        'pm' => 'pm',
        'polls' => 'poll',
        'posts' => 'post',
        'redir' => 'redirect',
        'root' => 'page',
        'sboxes' => 'shoutbox',
        'settings' => 'setting',
        'user-activation' => 'user_activation',
        'users' => 'user',
    ];

    public function change()
    {

        foreach (self::$tableMap as $name) {
            $newName = $this->getAdapter()->getAdapterTableName('_' . $name);
            $this->query('ALTER TABLE ' . $newName . ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
        }

    }
}
