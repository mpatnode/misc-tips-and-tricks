set -o vi
alias h='history'
alias ls='ls -F'
alias ds='cd ~/dev/web; docker-compose exec php bash'
alias bflog='while read -r line; do (echo $line | jq -r '\''.["@timestamp"] + ": " +  .["@message"]'\'' 2>/dev/null) || echo $line; done'
# alias bflog='while read -r line; do (echo $line | python -m json.tool 2>/dev/null) done | grep @message | sed -e '\''s/.*"@message": "//'\'' -e '\''s/",$//'\'''

alias mongod='/usr/local/opt/mongodb@3.6/bin/mongod --config /usr/local/etc/mongod.conf'

alias pio='ssh -i ~/aws/mpatnode.pem ubuntu@ec2-54-90-208-169.compute-1.amazonaws.com'
alias pioold='ssh -i ~/aws/mpatnode.pem ubuntu@ec2-54-144-74-254.compute-1.amazonaws.com'
alias nrst='vs -c '\''sudo /etc/init.d/nginx restart; sudo restart php7.0-fpm'\'''
alias smysql='sudo /usr/local/mysql/bin/mysqld_safe'
alias tlog='vs -c '\''tail -f /var/log/nginx/error.log'\'''
alias sqlfix='mysqlcheck --repair mysql proc -u root'
alias kmysql='sudo mysqladmin shutdown'
alias memc='memcached -vv | cat -v 2>&1'
alias redis=' ssh -f -N -L 6379:dev-shared-redis.e1kedr.0001.use1.cache.amazonaws.com:6379 sugarqabastion11.sugarops.com'
alias solr='ssh -f -N -L 8983:solr-onsugar-com-1437925068.us-east-1.elb.amazonaws.com:8983 dev4.onsugar.com'

alias dclean="docker volume rm $(docker volume ls -qf dangling=true); docker rmi $(docker images | grep '^<none>' | awk '{print $3}')"

alias dockup='docker-compose -f docker-compose-local.yml up -d; docker-compose logs -f nginx sparkle-cloud app'

alias stunnel='ssh -R 8000:localhost:8000 dev3.onsugar.com'

alias kickstash='ssh -t logstashnew.sugarops.com "sudo service nginx restart"'

alias gitdev='git checkout development'
alias gitmerged='git branch --merged origin/development | grep $(git rev-parse --abbrev-ref HEAD)'

alias sugarmig='cd /var/www/drupal.popsugar.com; python migrate/migrate.py | mysql -uroot drupal'
alias newmig='cd /var/www/drupal.popsugar.com; python migrate/create_migrate.py'

alias flushtmpl='vs -c '\''rm -rf /var/www/drupal.popsugar.com/themes/engines/smarty/templates_c/*'\'''
alias flushapc='mysql -uroot drupal < /var/www/drupal.popsugar.com/migrate/full_dump_mysql_caches.sql'
alias flushmc='cd ~/dev/web; docker-compose restart memcached'
# alias flushmc='vs -c '\''echo "flush_all" | nc localhost 11211'\'''
alias flushall='cd /var/www/drupal.popsugar.com; flushtmpl; flushapc; flushmc'
alias flushurl='curl -H sugar-regen-cache:1 -H shopstyle-proxy:1'

alias webs='csshX sugar-web'
alias pdbs='csshX sugar-db'
alias batchs='csshX sugar-batch'
alias slavelag="sudo mysql drupal -e 'SHOW SLAVE STATUS\G' | grep Seconds"

alias fixtitle='echo -n -e "\033]0;\007"'
alias bastion='ssh sugarqabastion11.sugarops.com'
alias gri='git rebase -i'
alias grc='git rebase --continue'
alias gmt='git mergetool'
#alias composer="COMPOSER_DISABLE_XDEBUG_WARN=1 php -d xdebug.remote_enable=0 -d xdebug.profiler_enable=0 -d xdebug.default_enable=0 /usr/local/bin/composer.phar --ignore-platform-reqs"
alias compi='composer install --ignore-platform-reqs'
alias gitundo='git reset --soft @^'

alias gitlsdel="git log --diff-filter=D --summary"

gitundel() {
    git checkout $(git rev-list -n 1 HEAD -- "$1")^ -- "$1"
}

# Copy a Drupal database table from one machine to yours
# Usage: cptbl hostname tablename
cptbl() {
    if ! nc -z localhost 3307 > /dev/null; then
        ssh -N -C -L 3307:localhost:3306 -f ${USER}@$1.onsugar.com;
    fi
    mysqldump -udruweb -pdevdevdev -h 127.0.0.1 -P3307 --single-transaction drupal $2 | pv -pte | mysql -uroot drupal
}

sqlrst() {
    sudo mysqladmin shutdown &> /dev/null
    while mysqladmin -u root status &> /dev/null
    do 
        echo "waiting.."
        sleep 1
    done; 
    sudo /usr/local/mysql/bin/mysqld_safe &
}

# Delete a branch(s) from github
# Usage gitdb branchname ...
gitdb()
{
    git branch --merged | grep -v '\*\|master\|develop' | sed 's/origin\///' | xargs -n 1 git branch -d
    git fetch -p
}

gitDB()
{
    for branch in $@
    do
        git branch -D $branch
        git push origin --delete $branch
    done
    git fetch -p
}

# Create a new branch and sync it with github
# Usage gitnb new-branch-name
gitnb()
{
    git checkout -b $@
    git push -u origin $@
}

phptags() {
    cd /var/www/drupal.popsugar.com
    /usr/local/bin/ctags --langmap=php:.engine.inc.module.theme.install.php --php-kinds=cdfi --languages=php --recurse -f ctags.new
    mv ctags.new tags
}

mylog() {
    if [[ ! -e /var/log/mysql ]]; then
        sudo mkdir /var/log/mysql
        sudo chown _mysql:_mysql /var/log/mysql
    fi
    if [[ "$1" == 'on' ]]; then
        mysql -u root << __END__
SET global log_output = 'FILE';
SET global general_log_file='/var/log/mysql/mysql.log';
SET global general_log = 1;
__END__
    elif [[ "$1" == 'off' ]]; then
        mysql -u root << __END__
SET global general_log = 0;
__END__
    else
        echo 'usage: mylog on|off'
    fi
}

# Usage: blowcache hostname urlpath
# IE: blowcache www.popsugar.com robots.txt
blowcache() {
    webs="15 16 17 25 26 27"
    for web in $webs
    do
        echo curl -v -H \"sugar-regen-cache: 1\" -H \"Host: $1\" \"https://sugarprodweb$web.sugarops.com$2\" 
        curl -A "Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/
6533.18.5" -k -v -H "sugar-regen-cache: 1" -H "Host: $1" https://sugarprodweb$web.sugarops.com$2 > /dev/null
        curl -A "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.95 Safari/537.36" -k -v -H "sugar-r
egen-cache: 1" -H "Host: $1" https://sugarprodweb$web.sugarops.com$2 > /dev/null
    done
}

ssh() {
    /usr/bin/ssh $*
    fixtitle
}

vcomposer() {
    if pwd | grep musthave > /dev/null 2>&1; then
        WORKDIR=/var/www/musthave
    else
        WORKDIR=/var/www/drupal.popsugar.com
    fi

    COMPOSER=composer

    if which vagrant > /dev/null 2>&1; then
        COMPOSER="/usr/local/bin/vagrant ssh default -c '(cd $WORKDIR; fcomposer $*)'"
    fi

    if which fcomposer > /dev/null 2>&1; then
        COMPOSER="fcomposer $*"
    fi

    eval $COMPOSER
}

mcdump() {
echo 'stats items'  \
| nc localhost 11211  \
| grep -oe ':[0-9]*:'  \
| grep -oe '[0-9]*'  \
| sort  \
| uniq  \
| xargs -L1 -I{} bash -c 'echo "stats cachedump {} 1000" | nc localhost 11211'
}

fixnet() {
sudo ifconfig vboxnet0 down
sudo ifconfig vboxnet0 up
echo "
rdr proto tcp from any to any port 80 -> 127.0.0.1 port 8080
rdr proto tcp from any to any port 443 -> 127.0.0.1 port 8443
" | sudo pfctl -ef -
}

# added by travis gem
[ -f /Users/mpatnode/.travis/travis.sh ] && source /Users/mpatnode/.travis/travis.sh

