@servers(["web" => 'deploybot@172.104.159.118'])

@task('deploy-beta', ['on' => 'web'])
cd /home/deploybot/NerdRunClub-beta

git pull

php artisan migrate

php artisan migrate:refresh --seed
@endtask

@task('deploy-live', ['on' => 'web'])

cd /home/deploybot/NerdRunClub

git pull

php artisan migrate

php artisan migrate:refresh --seed
@endtask
