<?php

use Phinx\Migration\AbstractMigration;

class InitialChange extends AbstractMigration
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
        foreach (self::$tableMap as $oldName => $newName) {
            $newName = $this->getAdapter()->getAdapterTableName('_' . $newName);
            $table = $this->table('-' . $oldName);
            $table->rename($newName);
            $table->update();
        }
    }
}
