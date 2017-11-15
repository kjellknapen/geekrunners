@servers(['web' => '172.104.159.118'])

@task('deploy-beta', ['on' => 'web'])
cd /home/deplybot/beta/NerdRunClub

git pull

php artisan migrate
@endtask