<?php
/* (c) Alexey Rogachev <arogachev90@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require 'recipe/yii.php';

/**
 * Yii 2 Advanced Project Template configuration
 */
set('shared_dirs', [
    /*
    'frontend/runtime',
    'backend/runtime',
    'console/runtime',
    'console/config'
    */
]);

set('shared_files', [
    /*
    'common/config/main-local.php',
    'common/config/params-local.php',
    'frontend/config/main-local.php',
    'frontend/config/params-local.php',
    'backend/config/main-local.php',
    'backend/config/params-local.php',
    'console/config/main-local.php',
    'console/config/params-local.php',
    'console/config/main.php',
    */
]);

/**
 * Initialization
 */
task('deploy:init', function () {
    run('{{bin/php}} {{release_path}}/init --env=Production --overwrite=n');
})->desc('Initialization');
/**
 * Run migrations
 */
task('deploy:run_migrations', function () {
    run('{{bin/php}} {{release_path}}/yii migrate up --interactive=0');
})->desc('Run migrations');

/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:init',
    'deploy:run_migrations',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');
after('deploy', 'success');

