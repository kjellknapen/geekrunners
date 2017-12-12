@servers(["web" => 'deploybot@172.104.159.118'])

@task('deploy-beta', ['on' => 'web'])
cd /home/deploybot/NerdRunClub-beta
git reset HEAD
git pull
php artisan migrate
@endtask

@task('deploy-live', ['on' => 'web'])

cd /home/deploybot/NerdRunClub
git reset HEAD
git pull
php artisan migrate
@endtask


@task('seed-live', ['on' => 'web'])

cd /home/deploybot/NerdRunClub

php artisan migrate:refresh --seed

@endtask

@task('seed-beta', ['on' => 'web'])

cd /home/deploybot/NerdRunClub-beta

php artisan migrate:refresh --seed

@endtask

@task('refresh-live', ['on' => 'web'])

cd /home/deploybot/NerdRunClub

php artisan migrate:refresh

@endtask

@task('refresh-beta', ['on' => 'web'])

cd /home/deploybot/NerdRunClub-beta

php artisan migrate:refresh

@endtask