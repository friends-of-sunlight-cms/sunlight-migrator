<?php

namespace Sunlight\Migrator;

use Kuria\Debug\Output;
use Sunlight\Core;
use Sunlight\Database\Database as DB;
use Sunlight\Database\DatabaseException;
use Sunlight\Page\Page;
use Sunlight\Util\ConfigurationFile;
use Sunlight\Util\Form;
use Sunlight\Util\Request;
use Sunlight\Util\StringGenerator;

const CONFIG_PATH = __DIR__ . '/../config.php';

require __DIR__ . '/class/IndexRemover.php';
require __DIR__ . '/class/MigrationRunner.php';

// bootstrap
require __DIR__ . '/../system/bootstrap.php';
Core::init([
    'minimal_mode' => true,
    'config_file' => false,
    'debug' => true,
]);

// config
$config = new ConfigurationFile(CONFIG_PATH);
$defaults = require __DIR__ . '/../system/config_template.php';
$defaults['secret'] = StringGenerator::generateString(64);

foreach ($defaults as $key => $value) {
    if (!$config->isDefined($key)) {
        $config[$key] = $value;
    }
}

/**
 * Installer labels
 */
abstract class Labels
{
    /** @var string */
    private static $language = '_none';
    /** @var string[][] */
    private static $labels = [
        // no language set
        '_none' => [
            'step.submit' => 'Pokračovat / Continue',

            'language.title' => 'Jazyk / Language',
            'language.text' => 'Choose a language / zvolte jazyk:',

            'migration.button.processing' => '...', // JS fallback
        ],

        // czech
        'cs' => [
            'step.submit' => 'Pokračovat',
            'step.reset' => 'Začít znovu',
            'step.exception' => 'Chyba',

            'config.title' => 'Konfigurace systému',
            'config.text' => 'Tento krok vygeneruje / přepíše soubor config.php',
            'config.error.db.port.invalid' => 'neplatný port',
            'config.error.db.name.empty' => 'název databáze nesmí být prázdný',
            'config.error.db.prefix.empty' => 'prefix nesmí být prázdný',
            'config.error.db.prefix.invalid' => 'prefix obsahuje nepovolené znaky',
            'config.error.db.connect.error' => 'nepodařilo se připojit k databázi, chyba: %error%',
            'config.error.db.create.error' => 'nepodařilo se vytvořit databázi (možná ji bude nutné vytvořit manuálně ve správě vašeho webhostingu): %error%',
            'config.error.write_failed' => 'Nepodařilo se zapsat %config_path%. Zkontrolujte přístupová práva.',
            'config.db' => 'Přístup k MySQL databázi',
            'config.db.server' => 'Server',
            'config.db.server.help' => 'host (např. localhost nebo 127.0.0.1)',
            'config.db.port' => 'Port',
            'config.db.port.help' => 'pokud je potřeba nestandardní port, uveďte jej',
            'config.db.user' => 'Uživatel',
            'config.db.user.help' => 'uživatelské jméno',
            'config.db.password' => 'Heslo',
            'config.db.password.help' => 'heslo (je-li vyžadováno)',
            'config.db.name' => 'Databáze',
            'config.db.name.help' => 'název databáze (pokud neexistuje, bude vytvořena)',
            'config.db.prefix' => 'Prefix',
            'config.db.prefix.help' => 'předpona názvu tabulek',

            'migration.title' => 'Migrace databáze',
            'migration.text' => 'Tento krok provede migraci tabulek v databázi.',
            'migration.error.confirmation.required' => 'je nezbytné potvrdit zahájení migrace',
            'migration.error.completed' => 'Migrace již byla dokončena, tento krok nelze opakovat.',
            'migration.error.dbversion' => 'Zahájení migrace není možné z důvodu používání starší verze databáze, která není podporována.',
            'migration.confirmation' => 'Migrace databáze',
            'migration.confirmation.text' => 'Pro případ neúspěchu migrace, je vhodné zazálohovat databázi před samotným spuštěním.',
            'migration.confirmation.allow' => 'rozumím, zahájit migraci databáze',
            'migration.button.processing' => 'Zpracovávám...',


            'complete.title' => 'Hotovo',
            'complete.whats_next' => 'Co dál?',
            'complete.success' => 'Migrace byla úspěšně dokončena!',
            'complete.migrationdir_warning' => 'Než budete pokračovat, je potřeba odstranit adresář migration ze serveru.',
            'complete.goto.web' => 'zobrazit stránky',
            'complete.goto.admin' => 'přihlásit se do administrace',
        ],

        // english
        'en' => [
            'step.submit' => 'Continue',
            'step.reset' => 'Start over',
            'step.exception' => 'Error',

            'config.title' => 'System configuration',
            'config.text' => 'This step will generate / overwrite the config file.',
            'config.error.db.port.invalid' => 'invalid port',
            'config.error.db.name.empty' => 'database name must not be empty',
            'config.error.db.prefix.empty' => 'prefix must not be empty',
            'config.error.db.prefix.invalid' => 'prefix contains invalid characters',
            'config.error.db.connect.error' => 'could not connect to the database, error: %error%',
            'config.error.db.create.error' => 'could not create database (perhaps you need to create it manually via your webhosting\'s management page): %error%',
            'config.error.write_failed' => 'Could not write %config_path%. Check filesystem permissions.',
            'config.db' => 'MySQL database access',
            'config.db.server' => 'Server',
            'config.db.server.help' => 'host (e.g. localhost or 127.0.0.1)',
            'config.db.port' => 'Port',
            'config.db.port.help' => 'if a non-standard port is needed, enter it',
            'config.db.user' => 'User',
            'config.db.user.help' => 'user name',
            'config.db.password' => 'Password',
            'config.db.password.help' => 'password (if required)',
            'config.db.name' => 'Database',
            'config.db.name.help' => 'name of the database (if it doesn\'t exist, it will be created)',
            'config.db.prefix' => 'Prefix',
            'config.db.prefix.help' => 'table name prefix',

            'migration.title' => 'Database migration',
            'migration.text' => 'This step migrates the tables in the database.',
            'migration.error.confirmation.required' => 'it\'s necessary to confirm the start of migration',
            'migration.error.completed' => 'The migration has already been completed, this step cannot be repeated.',
            'migration.error.dbversion' => 'Migration cannot be initiated due to an older version of the database that is not supported.',
            'migration.confirmation' => 'Database migration',
            'migration.confirmation.text' => 'In case the migration fails, it is advisable to back up the database before the actual launch.',
            'migration.confirmation.allow' => 'I understand, start the database migration',
            'migration.button.processing' => 'Processing...',

            'complete.title' => 'Complete',
            'complete.whats_next' => 'What\'s next?',
            'complete.success' => 'Migration has been completed successfully!',
            'complete.migrationdir_warning' => 'Before you continue, you must remove the install directory.',
            'complete.goto.web' => 'open the website',
            'complete.goto.admin' => 'log into administration',
        ],
    ];

    /**
     * Set the used language
     */
    static function setLanguage(string $language): void
    {
        self::$language = $language;
    }

    /**
     * Get a label
     *
     * @throws \RuntimeException if the language has not been set
     * @throws \OutOfBoundsException if the key is not valid
     */
    static function get(string $key, ?array $replacements = null): string
    {
        if (self::$language === null) {
            throw new \RuntimeException('Language not set');
        }

        if (!isset(self::$labels[self::$language][$key])) {
            throw new \OutOfBoundsException(sprintf('Unknown key "%s[%s]"', self::$language, $key));
        }

        $value = self::$labels[self::$language][$key];

        if (!empty($replacements)) {
            $value = strtr($value, $replacements);
        }

        return $value;
    }

    /**
     * Render a label as HTML
     */
    static function render(string $key, ?array $replacements = null): void
    {
        echo _e(self::get($key, $replacements));
    }
}

/**
 * Installer errors
 */
abstract class Errors
{
    static function render(array $errors, string $mainLabelKey): void
    {
        if (!empty($errors)) {
            ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li><?php is_array($error)
                            ? Labels::render("{$mainLabelKey}.error.{$error[0]}", $error[1])
                            : Labels::render("{$mainLabelKey}.error.{$error}") ?></li>
                <?php endforeach ?>
            </ul>
            <?php
        }
    }
}

/**
 * Step runner
 */
class StepRunner
{
    /** @var Step|null */
    private $current;
    /** @var Step[] */
    private $steps;

    /**
     * @param Step[] $steps
     */
    function __construct(array $steps)
    {
        $this->steps = $steps;

        // map step numbers
        $stepNumber = 0;

        foreach ($this->steps as $step) {
            $step->setNumber(++$stepNumber);
        }
    }

    /**
     * Run the steps
     */
    function run(): ?string
    {
        $this->current = null;
        $submittedNumber = (int) Request::post('step_number', 0);

        // gather vars
        $vars = [];

        foreach ($this->steps as $step) {
            foreach ($step->getVarNames() as $varName) {
                $vars[$varName] = Request::post($varName, null, true);
            }
        }

        // run
        foreach ($this->steps as $step) {
            $this->current = $step;

            $step->setVars($vars);
            $step->setSubmittedNumber($submittedNumber);

            if ($step->isSubmittable() && $step->getNumber() === $submittedNumber) {
                $step->handleSubmit();
            }

            if (!$step->isComplete()) {
                return $this->runStep($step, $vars);
            }

            $step->postComplete();
        }

        return null;
    }

    /**
     * Get current step
     */
    function getCurrent(): ?Step
    {
        return $this->current;
    }

    /**
     * Get total number of steps
     */
    function getTotal(): int
    {
        return count($this->steps);
    }

    private function runStep(Step $step, array $vars): string
    {
        ob_start();

        ?>
        <form method="post" autocomplete="off">
            <?php if ($step->hasText()): ?>
                <p><?php Labels::render($step->getMainLabelKey() . '.text') ?></p>
            <?php endif ?>

            <?php Errors::render($step->getErrors(), $step->getMainLabelKey()) ?>

            <?php $step->run() ?>

            <p>
                <?php if ($step->getNumber() > 1): ?>
                    <a class="btn btn-lg" id="start-over" href="<?= Core::getBaseUrl() ?>/migration/"><?php Labels::render('step.reset') ?></a>
                <?php endif ?>
                <?php if ($step->isSubmittable()): ?>
                    <?= Form::input('submit', 'step_submit', Labels::get('step.submit'), [
                        'id' => 'submit',
                        'class' => 'continue_' . $step->getMainLabelKey(),
                    ]) ?>
                    <?= Form::input('hidden', $step->getFormKeyVar(), '1') ?>
                    <?= Form::input('hidden', 'step_number', $step->getNumber()) ?>


                    <script type="application/javascript">
                        const form = document.querySelector('form');
                        function handleSubmit(event) {
                            const button = form.querySelector('.continue_migration');
                            button.disabled = true;
                            button.value = '<?= Labels::get('migration.button.processing'); ?>';
                            button.style.cursor = 'wait';
                        }
                        form.addEventListener('submit', handleSubmit);
                    </script>
                <?php endif ?>
            </p>

            <?php foreach ($vars as $name => $value): ?>
                <?php if ($value !== null): ?>
                    <?= Form::input('hidden', $name, $value) ?>
                <?php endif ?>
            <?php endforeach ?>
        </form>
        <?php

        return ob_get_clean();
    }
}

/**
 * Base step
 */
abstract class Step
{
    /** @var int */
    protected $number;
    /** @var int */
    protected $submittedNumber;
    /** @var array */
    protected $vars = [];
    /** @var bool */
    protected $submitted = false;
    /** @var array */
    protected $errors = [];
    /** @var ConfigurationFile */
    protected $config;

    function __construct(ConfigurationFile $config)
    {
        $this->config = $config;
    }

    abstract function getMainLabelKey(): string;

    function getFormKeyVar(): string
    {
        return "step_submit_{$this->number}";
    }

    /**
     * @return string[]
     */
    function getVarNames(): array
    {
        return [];
    }

    function setVars(array $vars): void
    {
        $this->vars = $vars;
    }

    function setNumber(int $number): void
    {
        $this->number = $number;
    }

    function getNumber(): int
    {
        return $this->number;
    }

    function setSubmittedNumber(int $submittedNumber): void
    {
        $this->submittedNumber = $submittedNumber;
    }

    function getSubmittedNumber(): int
    {
        return $this->submittedNumber;
    }

    function getTitle(): string
    {
        return Labels::get($this->getMainLabelKey() . '.title');
    }

    function isComplete(): bool
    {
        return
            (
                (!$this->isSubmittable() || $this->submitted)
                && empty($this->errors)
            ) || (
                $this->submittedNumber > $this->number
            );
    }

    function hasText(): bool
    {
        return true;
    }

    function isSubmittable(): bool
    {
        return true;
    }

    function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Handle step submission
     */
    function handleSubmit(): void
    {
        if ($this->isSubmittable()) {
            $this->doSubmit();
            $this->submitted = true;
        }
    }

    /**
     * Process the step form submission
     */
    protected function doSubmit(): void
    {
    }

    /**
     * Run the step
     */
    abstract function run(): void;

    /**
     * Execute some logic after the step has been completed
     * (e.g. before the next step is run)
     */
    function postComplete(): void
    {
    }
}

/**
 * Choose a language step
 */
class ChooseLanguageStep extends Step
{
    function getMainLabelKey(): string
    {
        return 'language';
    }

    function getVarNames(): array
    {
        return ['language'];
    }

    function isComplete(): bool
    {
        return
            parent::isComplete()
            && isset($this->vars['language'])
            && in_array($this->vars['language'], ['cs', 'en'], true);
    }

    function run(): void
    {
        ?>
        <ul class="big-list nobullets">
            <li><label><?= Form::input('radio', 'language', 'cs', ['checked' => true]) ?> Čeština</label></li>
            <li><label><?= Form::input('radio', 'language', 'en') ?> English</label></li>
        </ul>
        <?php
    }

    function postComplete(): void
    {
        Labels::setLanguage($this->vars['language']);
    }
}

/**
 * Configuration step
 */
class ConfigurationStep extends Step
{
    function getMainLabelKey(): string
    {
        return 'config';
    }

    protected function doSubmit(): void
    {
        // load data
        $config = [
            'db.server' => trim(Request::post('config_db_server', '')),
            'db.port' => (int) trim(Request::post('config_db_port', '')) ?: null,
            'db.user' => trim(Request::post('config_db_user', '')),
            'db.password' => trim(Request::post('config_db_password', '')),
            'db.name' => trim(Request::post('config_db_name', '')),
            'db.prefix' => trim(Request::post('config_db_prefix', '')),
            'fallback_lang' => $this->vars['language'],
            // I don't want to deal with it in the migrator
            'secret' => trim(StringGenerator::generateString(64)),
            'debug' => false,
            'locale' => null,
            'timezone' => null,
        ];

        // validate
        if ($config['db.port'] !== null && $config['db.port'] <= 0) {
            $this->errors[] = 'db.port.invalid';
        }

        if ($config['db.name'] === '') {
            $this->errors[] = 'db.name.empty';
        }

        if ($config['db.prefix'] === '') {
            $this->errors[] = 'db.prefix.empty';
        } elseif (!preg_match('{[a-zA-Z0-9_]+$}AD', $config['db.prefix'])) {
            $this->errors[] = 'db.prefix.invalid';
        }

        // connect to the database
        if (empty($this->errors)) {
            try {
                DB::connect($config['db.server'], $config['db.user'], $config['db.password'], '', $config['db.port'], $config['db.prefix']);
            } catch (DatabaseException $e) {
                $this->errors[] = ['db.connect.error', ['%error%' => $e->getMessage()]];
            }

            if (empty($this->errors)) {
                // attempt to create the database if it does not exist
                try {
                    DB::query('CREATE DATABASE IF NOT EXISTS ' . DB::escIdt($config['db.name']) . ' COLLATE \'utf8mb4_unicode_ci\'');
                } catch (DatabaseException $e) {
                    $this->errors[] = ['db.create.error', ['%error%' => $e->getMessage()]];
                }
            }
        }

        // generate config file
        if (empty($this->errors)) {
            foreach ($config as $key => $value) {
                $this->config[$key] = $value;
            }

            try {
                $this->config->save();
            } catch (\Throwable $e) {
                $this->errors[] = ['write_failed', ['%config_path%' => CONFIG_PATH]];
            }
        }
    }

    function isComplete(): bool
    {
        if (parent::isComplete() && is_file(CONFIG_PATH)) {
            try {
                DB::connect($this->config['db.server'], $this->config['db.user'], $this->config['db.password'], '', $this->config['db.port'], $this->config['db.prefix']);

                return true;
            } catch (DatabaseException $e) {
            }
        }

        return false;
    }

    function run(): void
    {
        ?>

        <fieldset>
            <legend><?php Labels::render('config.db') ?></legend>
            <table>
                <tr>
                    <th><?php Labels::render('config.db.server') ?></th>
                    <td><?= Form::input('text', 'config_db_server', Request::post('config_db_server', $this->config['db.server'])) ?></td>
                    <td class="help"><?php Labels::render('config.db.server.help') ?></td>
                </tr>
                <tr>
                    <th><?php Labels::render('config.db.port') ?></th>
                    <td><?= Form::input('text', 'config_db_port', Request::post('config_db_port', $this->config['db.port'])) ?></td>
                    <td class="help"><?php Labels::render('config.db.port.help') ?></td>
                </tr>
                <tr>
                    <th><?php Labels::render('config.db.user') ?></th>
                    <td><?= Form::input('text', 'config_db_user', Request::post('config_db_user', $this->config['db.user'])) ?></td>
                    <td class="help"><?php Labels::render('config.db.user.help') ?></td>
                </tr>
                <tr>
                    <th><?php Labels::render('config.db.password') ?></th>
                    <td><?= Form::input('text', 'config_db_password', Request::post('config_db_password')) ?></td>
                    <td class="help"><?php Labels::render('config.db.password.help') ?></td>
                </tr>
                <tr>
                    <th><?php Labels::render('config.db.name') ?></th>
                    <td><?= Form::input('text', 'config_db_name', Request::post('config_db_name', $this->config['db.name'])) ?></td>
                    <td class="help"><?php Labels::render('config.db.name.help') ?></td>
                </tr>
                <tr>
                    <th><?php Labels::render('config.db.prefix') ?></th>
                    <td><?= Form::input('text', 'config_db_prefix', Request::post('config_db_prefix', $this->config['db.prefix'])) ?></td>
                    <td class="help"><?php Labels::render('config.db.prefix.help') ?></td>
                </tr>
            </table>
        </fieldset>
        <?php
    }
}

/**
 * migration database step
 */
class MigrationDatabaseStep extends Step
{
    /** @var string[] */
    private static $baseTableNames = [
        'article',
        'box',
        'user_group',
        'gallery_image',
        'iplog',
        'log',
        'pm',
        'poll',
        'post',
        'page',
        'shoutbox',
        'setting',
        'user',
        'user_activation',
        'redirect',
    ];
    /** @var array|null */
    private $existingTableNames;
    /** @var bool */
    private $successfulMigration = false;

    function getMainLabelKey(): string
    {
        return 'migration';
    }

    protected function doSubmit(): void
    {
        $confirmedMigration = (bool) Request::post('confirm_migration', false);

        $isMigrated = $this->isDatabaseMigrated();

        if ($isMigrated) {
            $this->errors[] = 'completed';
        }

        if (!$isMigrated && !$this->checkMinimalDatabaseVersion()) {
            $this->errors[] = 'dbversion';
        }

        if (!$isMigrated && !$confirmedMigration) {
            $this->errors[] = 'confirmation.required';
        }

        // migrate the database
        if (empty($this->errors)) {
            // use database
            DB::query('USE ' . DB::escIdt($this->config['db.name']));

            // remove all indexes from all tables
            $indexRemover = new IndexRemover(DB::getTablesByPrefix($this->config['db.prefix']));
            $indexRemover->remove();

            // migration
            $migrationRunner = new MigrationRunner();
            if (!$migrationRunner->isInstalled()) {
                $this->successfulMigration = $migrationRunner->install();
            } else {
                $this->successfulMigration = true;
            }
        }

        // after migration
        if ($this->successfulMigration) {
            // update page tree
            Page::getTreeManager()->refresh();
        }
    }

    function isSubmittable(): bool
    {
        return !$this->isDatabaseMigrated() && $this->checkMinimalDatabaseVersion();
    }

    function isComplete(): bool
    {
        return
            parent::isComplete()
            && $this->successfulMigration
            && $this->isDatabaseMigrated()
            && $this->isDatabaseInstalled();
    }

    function run(): void
    {
        $validDbVersion = $this->checkMinimalDatabaseVersion();
        $isMigrated = $this->isDatabaseMigrated();
        ?>
        <?php if ($isMigrated): ?>
            <p class="msg warning"><?php Labels::render('migration.error.completed') ?></p>
        <?php endif ?>
        <?php if (!$isMigrated && !$validDbVersion): ?>
            <p class="msg warning"><?php Labels::render('migration.error.dbversion') ?></p>
        <?php endif ?>
        <?php if (!$this->isDatabaseMigrated() && $validDbVersion): ?>
            <fieldset>
                <legend><?php Labels::render('migration.confirmation') ?></legend>
                <p class="msg warning"><?php Labels::render('migration.confirmation.text') ?></p>
                <p>
                    <label>
                        <?= Form::input('checkbox', 'confirm_migration', '1', [
                            'checked' => Form::loadCheckbox('confirm_migration', false, $this->getFormKeyVar()),
                        ]) ?>
                        <?php Labels::render('migration.confirmation.allow' ) ?>
                    </label>
                </p>
            </fieldset>
        <?php endif ?>
        <?php
    }

    private function isDatabaseInstalled(): bool
    {
        return count(array_diff($this->getTableNames(), $this->getExistingTableNames())) === 0;
    }

    private function isDatabaseMigrated(): bool
    {
        $prefix = $this->config['db.prefix'];

        DB::query('USE ' . DB::escIdt($this->config['db.name']));
        $tables = DB::getTablesByPrefix($prefix);
        if (in_array($prefix . '_setting', $tables)) {
            $version = DB::result(DB::query('SELECT val FROM ' . DB::escIdt($prefix . '_setting') . ' WHERE var=' . DB::val('dbversion')));
            return ($version === 'sl8db-002');
        }
        return false;
    }

    private function checkMinimalDatabaseVersion(): bool
    {
        $prefix = $this->config['db.prefix'];

        DB::query('USE ' . DB::escIdt($this->config['db.name']));
        $tables = DB::getTablesByPrefix($prefix);
        if (in_array($prefix . '-settings', $tables)) {
            $version = DB::result(DB::query('SELECT val FROM ' . DB::escIdt($prefix . '-settings') . ' WHERE var=' . DB::val('dbversion')));
            return ($version === '7.5.3');
        }
        return false;
    }

    /**
     * @return string[]
     */
    private function getExistingTableNames(): array
    {
        if ($this->existingTableNames === null) {
            $this->existingTableNames = DB::queryRows(
                'SHOW TABLES FROM ' . DB::escIdt($this->config['db.name']) . ' LIKE ' . DB::val($this->config['db.prefix'] . '_%'),
                null,
                0,
                false,
                true
            ) ?: [];
        }

        return $this->existingTableNames;
    }

    /**
     * @return string[]
     */
    private function getTableNames(): array
    {
        $prefix = $this->config['db.prefix'] . '_';

        return array_map(function ($baseTableName) use ($prefix) {
            return $prefix . $baseTableName;
        }, self::$baseTableNames);
    }
}

/**
 * Complete step
 */
class CompleteStep extends Step
{
    function getMainLabelKey(): string
    {
        return 'complete';
    }

    function isSubmittable(): bool
    {
        return false;
    }

    function hasText(): bool
    {
        return false;
    }

    function isComplete(): bool
    {
        return false;
    }

    function run(): void
    {
        ?>
        <p class="msg success"><?php Labels::render('complete.success') ?></p>
        <p class="msg warning"><?php Labels::render('complete.migrationdir_warning') ?></p>

        <h2><?php Labels::render('complete.whats_next') ?></h2>

        <ul class="big-list">
            <li><a href="<?= _e(Core::getBaseUrl()->getPath()) ?>/" target="_blank"><?php Labels::render('complete.goto.web') ?></a></li>
            <li><a href="<?= _e(Core::getBaseUrl()->getPath()) ?>/admin/" target="_blank"><?php Labels::render('complete.goto.admin') ?></a></li>
        </ul>
        <?php
    }
}

// create step runner
$stepRunner = new StepRunner([
    new ChooseLanguageStep($config),
    new ConfigurationStep($config),
    new MigrationDatabaseStep($config),
    new CompleteStep($config),
]);

// run
try {
    $content = $stepRunner->run();
} catch (\Throwable $e) {
    Output::cleanBuffers();

    ob_start();
    ?>
    <h2><?php Labels::render('step.exception') ?></h2>
    <pre><?= _e((string) $e) ?></pre>
    <?php
    $content = ob_get_clean();
}

$step = $stepRunner->getCurrent();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            margin: 1em;
            background-color: yellow;
            font-family: sans-serif;
            font-size: 13px;
            color: #000;
        }

        body {
            height: 100vh;
            background: repeating-linear-gradient(
                    45deg,
                    hsl(60 40% 50% / 1),
                    hsl(60 40% 50% / 1) 100px,
                    hsl(0 40% 0% / 1) 100px,
                    hsl(0 40% 0% / 1) 200px
            );
        }

        a {
            color: #f60;
            text-decoration: none;
        }

        a:hover {
            color: #000;
        }

        h1, h2, h3, p, ol, ul, pre {
            line-height: 1.5;
        }

        h1 {
            margin: 0;
            padding: 0.5em 1em;
            font-size: 1.5em;
            background-color: #eee;
        }

        h2, h3 {
            margin: 0.5em 0;
        }

        p, ol, ul, pre {
            margin: 1em 0;
        }

        #step span {
            padding: 0 0.3em;
            margin-right: 0.2em; /*background-color: #fff;*/
        }

        #system-name {
            float: right;
            color: #f60;
        }

        h2 {
            font-size: 1.3em;
        }

        h3 {
            font-size: 1.1em;
        }

        h2:first-child, h3:first-child {
            margin-top: 0;
        }

        ul, ol {
            padding-left: 40px;
        }

        .big-list {
            margin: 0.5em 0;
            font-size: 1.5em;
        }

        .nobullets {
            list-style-type: none;
            padding-left: 0;
        }

        ul.errors {
            padding-top: 10px;
            padding-bottom: 10px;
            background-color: #eee;
        }

        ul.errors li {
            font-size: 1.1em;
            color: red;
        }

        select, input[type=text], input[type=password], input[type=reset], input[type=button], input[type=email], button {
            padding: 5px;
        }

        .btn {
            display: inline-block;
        }

        .btn, input[type=submit], input[type=button], input[type=reset], button {
            cursor: pointer;
            padding: 4px 16px;
            border: 1px solid #bbbbbb;
            background: #ededed;
            background: linear-gradient(to bottom, #f5f5f5, #ededed);
            color: #000;
            line-height: normal;
        }

        .btn:hover, input[type=submit]:hover, input[type=button]:hover, input[type=reset]:hover, button:hover {
            color: #fff;
            background: #fe5300;
            background: linear-gradient(to bottom, #fe7b3b, #ea4c00);
            border-color: #ea4c00;
            outline: none;
        }

        .btn-lg, input[type=submit] {
            padding: 10px;
            font-size: 1.2em;
        }

        fieldset {
            margin: 2em 0;
            border: 1px solid #ccc;
            padding: 10px;
        }

        legend {
            padding: 0 10px;
            font-weight: bold;
        }

        th {
            white-space: nowrap;
        }

        th, td {
            padding: 3px 5px;
        }

        form tbody th {
            text-align: right;
        }

        form td.help {
            color: #777;
        }

        pre {
            overflow: auto;
        }

        p.msg {
            padding: 10px;
        }

        p.msg.success {
            color: #080;
            background-color: #d9ffd9;
        }

        p.msg.notice {
            color: #000;
            background-color: #d9e3ff;
        }

        p.msg.warning {
            color: #c00;
            background-color: #ffd9d9;
        }

        #wrapper {
            margin: 0 auto;
            min-width: 600px;
            max-width: 950px;
        }

        #content {
            padding: 15px 30px 25px 30px;
            background-color: #fff;
        }

        #start-over {
        }

        #submit {
            float: right;
        }

        .cleaner {
            clear: both;
        }
    </style>
    <title><?= _e("[{$step->getNumber()}/{$stepRunner->getTotal()}]: {$step->getTitle()}") ?></title>
</head>

<body>

<div id="wrapper">

    <h1>
            <span id="step">
                <span><?= $step->getNumber(), '/', $stepRunner->getTotal() ?></span>
                <?= _e($step->getTitle()) ?>
            </span>
        <span id="system-name">
                Migrator SunLight CMS <?= Core::VERSION ?>
            </span>
    </h1>

    <div id="content">
        <?= $content ?>

        <div class="cleaner"></div>
    </div>

</div>

</body>
</html>
