<?php

namespace Sunlight\Migrator;

use Sunlight\Database\Database as DB;

require __DIR__ . '/PatchInstaller.php';

class MigrationRunner extends PatchInstaller
{
    protected function verify(): bool
    {
        $requiredTables = [
            DB::table('article'),
            DB::table('box'),
            DB::table('gallery_image'),
            DB::table('iplog'),
            DB::table('log'),
            DB::table('page'),
            DB::table('pm'),
            DB::table('poll'),
            DB::table('post'),
            DB::table('redirect'),
            DB::table('setting'),
            DB::table('shoutbox'),
            DB::table('user'),
            DB::table('user_activation'),
            DB::table('user_group'),
        ];
        $missingTables = $this->checkTables($requiredTables);
        
        return count($missingTables) === 0;
    }

    protected function doInstall(): void
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '../patches/';

        $this->loadSqlDump($path . '20230524091022_initial_change.sql');
        $this->loadSqlDump($path . '20230524091100_change_engine.sql');
        $this->loadSqlDump($path . '20230524092152_update_article_table.sql');
        $this->loadSqlDump($path . '20230525092217_update_box_table.sql');
        $this->loadSqlDump($path . '20230525100300_update_gallery_image_table.sql');
        $this->loadSqlDump($path . '20230525100816_update_iplog_table.sql');
        $this->loadSqlDump($path . '20230525101249_update_page_table.sql');
        $this->loadSqlDump($path . '20230525103013_update_pm_table.sql');
        $this->loadSqlDump($path . '20230525105554_update_poll_table.sql');
        $this->loadSqlDump($path . '20230525110147_update_post_table.sql');
        $this->loadSqlDump($path . '20230525111030_update_redirect_table.sql');
        $this->loadSqlDump($path . '20230525111356_update_setting_table.sql');
        $this->loadSqlDump($path . '20230527124935_update_shout_box_table.sql');
        $this->loadSqlDump($path . '20230527125448_update_user_table.sql');
        $this->loadSqlDump($path . '20230527145607_update_user_activation_table.sql');
        $this->loadSqlDump($path . '20230527150510_update_user_group_table.sql');
        $this->loadSqlDump($path . '20230527153000_add_log_table.sql');
        $this->loadSqlDump($path . '20230527181932_update_articles_data.sql');
        $this->loadSqlDump($path . '20230527182032_update_box_data.sql');
        $this->loadSqlDump($path . '20230527182839_update_galery_images_data.sql');
        $this->loadSqlDump($path . '20230527183152_update_pages_data.sql');
        $this->loadSqlDump($path . '20230527184034_update_posts_data.sql');
        $this->loadSqlDump($path . '20230527184844_update_settings_data.sql');
        $this->loadSqlDump($path . '20230527202154_update_user_groups_data.sql');
        $this->loadSqlDump($path . '20230527210617_update_users_data.sql');
        $this->loadSqlDump($path . '20230527220030_convert_smiley_to_emoji.sql');
        $this->loadSqlDump($path . '20231002220000_add_table_indexes.sql');
    }
}