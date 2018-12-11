<?php
namespace Deployer;

require 'recipe/yii2-app-advanced.php';

// Configuration

set('repository', 'gitea@git.wenjy.top:wen/admin_system.git');
set('git_tty', true); // [Optional] Allocate tty for git on first deployment
add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);
set('default_timeout', 600);

// Hosts

host('git.wenjy.top')
    ->user('www')
    ->stage('production')
    ->set('deploy_path', '/www/wwwroot/admin_system');


// Tasks

/*desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
after('deploy:symlink', 'php-fpm:restart');*/

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
