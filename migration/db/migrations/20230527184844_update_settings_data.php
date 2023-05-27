<?php

use Phinx\Migration\AbstractMigration;

class UpdateSettingsData extends AbstractMigration
{
    public function change()
    {
        $prefixedTableName = $this->getAdapter()->getAdapterTableName('_setting');

        $this->query("UPDATE " . $prefixedTableName . " SET var=SUBSTR(var, 2) WHERE var LIKE '.%';");

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('web', 1)
            ->set('admin', 1)
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('web', 0)
            ->set('admin', 1)
            ->whereInList('var', [
                'adminscheme',
                'adminscheme_mode',
                'admin_index_custom',
                'admin_index_custom_pos',
            ])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('preload', 1)
            ->whereNotInList('var', [
                'admin_index_custom',
                'admin_index_custom_pos',
                'cron_auth',
                'rules',
            ])
            ->execute();


        $this->table('_setting')
            ->insert([
                ['var' => 'adminpagelist_mode', 'val' => '0', 'preload' => 1, 'web' => 0, 'admin' => 1],
                ['var' => 'galdefault_per_page', 'val' => '9', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'galdefault_per_row', 'val' => '3', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'galdefault_thumb_h', 'val' => '110', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'galdefault_thumb_w', 'val' => '147', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'articlesperpage', 'val' => '15', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'topicsperpage', 'val' => '30', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'article_pic_thumb_h', 'val' => '200', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'article_pic_thumb_w', 'val' => '200', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'version_check', 'val' => '1', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'pretty_urls', 'val' => '0', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'antispamtimeout', 'val' => '60', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'adminscheme_dark', 'val' => '0', 'preload' => 1, 'web' => 0, 'admin' => 1],
                ['var' => 'log_level', 'val' => '5', 'preload' => 1, 'web' => 1, 'admin' => 1],
                ['var' => 'log_retention', 'val' => '30', 'preload' => 1, 'web' => 1, 'admin' => 1],
            ])
            ->saveData();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('val', '')
            ->where('var', 'install_check')
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('var', 'pretty_urls')
            ->where('var', 'modrewrite')
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('val', 'cs')
            ->where(['var' => 'language', 'val' => 'default'])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('var', 'default_template')
            ->where(['var' => 'template'])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('val', 'default')
            ->where(['var' => 'default_template'])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('var', 'antispamtimeout')
            ->where('var', 'postsendexpire')
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('var', 'adminscheme_dark')
            ->where('var', 'adminscheme_mode')
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('val', '1')
            ->where(['var' => 'adminscheme_dark', 'val' => '2'])
            ->execute();

        $this->getQueryBuilder()
            ->delete($prefixedTableName)
            ->whereInList('var', [
                'printart',
                'extend_enabled',
                'ajaxfm',
                'wysiwyg',
                'codemirror',
                'lightbox',
                'url',
                'banned',
                'keywords',
                'proxy_mode',
                'rss',
                'rsslimit',
                'modrewrite',
                'smileys',
                'postsendexpire',
                'adminscheme_mode',
            ])
            ->execute();

        $this->getQueryBuilder()
            ->update($prefixedTableName)
            ->set('val', '8.0.0')
            ->where(['var' => 'dbversion'])
            ->execute();

        $this->query("UPDATE " . $prefixedTableName . " SET val=(SELECT * FROM (SELECT val FROM " . $prefixedTableName . " WHERE var = 'article_pic_w') AS mysql_sucks) WHERE var = 'article_pic_thumb_w'");
        $this->query("UPDATE " . $prefixedTableName . " SET val=(SELECT * FROM (SELECT val FROM " . $prefixedTableName . " WHERE var = 'article_pic_h') AS mysql_sucks) WHERE var = 'article_pic_thumb_h'");
        $this->query("UPDATE " . $prefixedTableName . " SET val = val * 3 WHERE var IN ('article_pic_w', 'article_pic_h')");

        $this->query("UPDATE " . $prefixedTableName . " SET `val`=`val` + 1 WHERE `var` = 'cacheid'");
    }
}
