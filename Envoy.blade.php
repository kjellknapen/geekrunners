@setup
$server = "142.93.130.220";
$project = "geekrunners.knapenkjell.com";
$repo = "git@github.com:kjellknapen/geekrunners.git";
$branch = "master";
$userAndServer = 'deploybot@'. $server;
$baseDir = "/home/deploybot/{$project}";

function logMessage($message) {
return "echo '\033[32m" .$message. "\033[0m';\n";
}
@endsetup

@servers(['local' => '127.0.0.1', 'remote' => $userAndServer])

@story('deploy')
pushLocal
checkRepo
deployment
@endstory

@task('pushLocal',['on' => 'local'])
{{ logMessage("Pushing to git...") }}
git add .
git commit -m "{{ $commit }}"
git push
@endtask

@task('checkRepo',['on' => 'remote'])
{{ logMessage("Checking repository...") }}
if [ ! -d {{ $baseDir }} ]
then
git clone {{ $repo }} {{ $project }}
cd {{ $baseDir }}
git checkout {{ $branch }}
chmod 770 -R {{ $baseDir }}/storage
fi
@endtask

@task('deployment',['on' => 'remote'])
{{ logMessage("💻  Deploying code changes...") }}
cd {{ $baseDir }}
git stash
git pull
composer install
yarn
yarn run prod
php artisan migrate
php artisan config:clear
php artisan cache:clear
php artisan config:cache
sudo apachectl restart
@endtask
