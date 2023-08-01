<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Gemeinsames Mittagessen');

// Project repository
set('repository', 'git@github.com:pc-web-it/laravel-gemeinsames-mitagessen-tool.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);
set('allow_anonymous_stats', false);
set('writable_mode', 'chmod');

// Hosts
host('gemeinsames-mittagessen.pc-web.cloud')
    ->set('deploy_path', '/var/www/clients/client2/web245/web/app')
    ->set('bin/php', '/opt/php-8.2/bin/php')
    ->set('bin/composer', '{{bin/php}} {{release_path}}/composer.phar')
    ->set('fcgi', '/var/lib/php5-fpm/web245*.sock')
    ->set('tmp_dir', '/var/www/clients/client2/web245/tmp')
    ->set('branch', 'main')
    ->user('pc_webmittagessen')
    ->stage('production');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('deploy:clearOpCache', function() {
    $fcgi = run('ls {{fcgi}}');
    run("cd {{release_path}} && {{bin/php}} cachetool.phar --fcgi=$fcgi --tmp-dir={{tmp_dir}} opcache:reset");
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'artisan:migrate');

after('deploy:symlink', 'deploy:clearOpCache');


