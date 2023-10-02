<?php

namespace Sunlight\Migrator;

use Sunlight\Database\Database as DB;

class IndexRemover
{
    /** @var array */
    private $tables;

    public function __construct(array $tables)
    {
        $this->tables = $tables;
    }

    public function remove()
    {
        foreach ($this->tables as $table) {
            $this->removeIndex($table);
        }
    }

    private function removeIndex(string $table)
    {
        $query = DB::query('SHOW INDEX FROM ' . DB::escIdt($table));
        if (DB::size($query) > 0) {
            $indexes = [];
            while ($row = DB::row($query)) {
                $indexName = $row['Key_name'];
                if ($indexName === 'PRIMARY') {
                    continue;
                }
                $indexes[] = $indexName;
            }
            // unique values
            $indexes = array_unique($indexes);

            if (count($indexes) > 0) {
                $dropString = implode(', ', array_map(function ($idx) {
                    return 'DROP INDEX ' . DB::escIdt($idx);
                }, $indexes));

                DB::query('ALTER TABLE ' . DB::escIdt($table) . ' ' . $dropString . ';');
            }
        }
    }
}