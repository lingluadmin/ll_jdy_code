#!/bin/bash

set -e

prj_dir=$(cd $(dirname $0); pwd -P)
apuppy_dir="$prj_dir/apuppy"
devops_prj_path="$apuppy_dir/devops" # should be defined to this name

load_init_module=1
# define: load_init_module
# defined: init_config_by_developer_name / load_config / do_init

templates_dir="$apuppy_dir/templates"
config_dir="$apuppy_dir/config"

mysql_image=docker.sunfund.com/mysql:5.6
redis_image=docker.sunfund.com/redis:3.0.1
nginx_image=docker.sunfund.com/nginx:1.11-alpine
php_base_image=docker.sunfund.com/9dy-php:5.6.8-fpm
php_base_image_push=docker-publish.sunfund.com/9dy-php:5.6.8-fpm
php_crontab_image_push=docker-publish.sunfund.com/9dy-crontab:5.6.8-fpm

work_dir_in_container='/opt/src'

function init_config_by_developer_name() {

    app=$developer_name-9douyu

    app_storage_dir=/opt/data/$app
    app_persitent_storage_dir=$app_storage_dir/persistent
    mysql_data_dir="$app_persitent_storage_dir/mysql/data"
    project_config_file=$app_persitent_storage_dir/auto-gen.manager.config

    app_runtime_storage_dir=$app_storage_dir/runtime
    php_storage_dir="$app_runtime_storage_dir/storage"

    app_log_dir="$app_runtime_storage_dir/logs"

    app_nginx_config_dir="$app_persitent_storage_dir/nginx-config"
    export_data_file="$app_persitent_storage_dir/export-init-data.sh"

	mysql_container=$app-mysql
    redis_container=$app-redis
    php_nginx_container=$app-php-nginx
    php_container=$app-php
    php_schedule_container=$app-php-schedule
    gateway_nginx_container="$app-gateway-nginx"
}

function _ensure_dirs() {

    ensure_dir "$app_runtime_storage_dir"
    ensure_dir "$app_persitent_storage_dir"
    ensure_dir "$app_nginx_config_dir"

	ensure_dir "$php_storage_dir/9douyu-core/logs"
    ensure_dir "$php_storage_dir/9douyu-module/logs"
    ensure_dir "$php_storage_dir/9douyu-module/framework/sessions"
    ensure_dir "$php_storage_dir/9douyu-module/framework/cache"
    ensure_dir "$php_storage_dir/9douyu-service/logs"

    ensure_dir "$app_log_dir"
    ensure_dir "$app_log_dir/php"
    ensure_dir "$app_log_dir/crontab"

    if [ ! -f "$app_log_dir/php/php-fpm-error.log" ]; then
        run_cmd "touch $app_log_dir/php/php-fpm-error.log"
    fi
    if [ ! -f "$app_log_dir/php/php-fpm-slow" ]; then
        run_cmd "touch $app_log_dir/php/php-fpm-slow.log"
    fi

    if [ ! -f "$app_log_dir/crontab/archive_gateway_nginx.log" ]; then
        run_cmd "touch $app_log_dir/crontab/archive_gateway_nginx.log"
    fi
    if [ ! -f "$app_log_dir/crontab/archive_php_nginx.log" ]; then
        run_cmd "touch $app_log_dir/crontab/archive_php_nginx.log"
    fi
}

function do_init_for_dev() {

    _ensure_dirs

    local extra_kv_list="developer_name=$developer_name env=$env"

    local config_key="9dy.vars"
    local template_file="$templates_dir/manager.config.template"
    local config_file_name="sites-config"
    local dst_file=$project_config_file
    render_server_config $config_key $template_file $config_file_name $dst_file $extra_kv_list

	config_key='9dy'
    template_file="$templates_dir/9douyu-dev.yaml.template"
    config_file_name="sites-config"
    dst_file="$app_persitent_storage_dir/9douyu-dev.yaml"
    render_server_config $config_key $template_file $config_file_name $dst_file $extra_kv_list

    # TODO
    # template_file="$templates_dir/rsyslog.conf.template"
    # dst_file="$apuppy_dir/tmp/rsyslog.conf"
    # render_server_config $config_key $template_file $config_file_name $dst_file $extra_kv_list

    template_file="$templates_dir/nginx-for-dev/9douyu.conf"
    dst_file="$app_nginx_config_dir/9douyu.conf"
    render_server_config $config_key $template_file $config_file_name $dst_file $extra_kv_list

    template_file="$templates_dir/nginx-for-dev/fastcgi"
    dst_file="$app_nginx_config_dir/fastcgi"
    run_cmd "cp $template_file $dst_file"
}

function build_code_config() {

    load_config_for_dev

    local config_key=config
    local config_file=$app_persitent_storage_dir/9douyu-dev.yaml

    render_local_config $config_key $prj_dir/9douyu-core/.env.example $config_file $prj_dir/9douyu-core/.env
    render_local_config $config_key $prj_dir/9douyu-module/.env.example $config_file $prj_dir/9douyu-module/.env
    render_local_config $config_key $prj_dir/9douyu-service/.env.example $config_file $prj_dir/9douyu-service/.env

    run_cmd "cp $prj_dir/9douyu-core/config/cache.example $prj_dir/9douyu-core/config/cache.php"
    run_cmd "cp $prj_dir/9douyu-module/config/cache.example $prj_dir/9douyu-module/config/cache.php"
    run_cmd "cp $prj_dir/9douyu-module/config/oss.example $prj_dir/9douyu-module/config/oss.php"
}

function load_config_for_dev() {

    if [ ! -f $project_config_file ]; then
        echo "Config file $project_config_file is not existent. Please call init_dev first."
        exit 1
    fi

    http_port=$(read_kv_config "$project_config_file" "http_port")
    mysql_port="$(read_kv_config "$project_config_file" "mysql_port")"
}

function load_config_for_deploy() {
    app_http_port=$(read_kv_config "$project_config_file" "http_port")
    php_fpm_port=$(read_kv_config "$project_config_file" "php_fpm_port")
    php_schedule_port=$(read_kv_config "$project_config_file" "php_schedule_port")
    php_nginx_port=$(read_kv_config "$project_config_file" "php_nginx_port")
    app_https_port=$(read_kv_config "$project_config_file" "https_port")
}

function do_init_for_deploy() {
    _ensure_dirs
    run_cmd "cp $config_dir/env-config/config.$env $project_config_file"
}

source $devops_prj_path/base.sh

function init_app() {
    local cmd="cd $work_dir_in_container"
    cmd="$cmd; cd $work_dir_in_container/9douyu-core"

    cmd="$cmd; php artisan migrate --force"
    cmd="$cmd; php artisan db:seed --force"

    cmd="$cmd; cd $work_dir_in_container/9douyu-module"
    cmd="$cmd; php artisan migrate --force"
    cmd="$cmd; php artisan db:seed --force"

    cmd="$cmd; cd $work_dir_in_container/9douyu-service"
    cmd="$cmd; php artisan migrate --force"
    cmd="$cmd; php artisan db:seed --force"
    _send_cmd_to_php "$cmd"
}

function gen_token() {
    _send_cmd_to_php "cd $work_dir_in_container; php 9douyu-module/artisan AccessTokenCore"
    _send_cmd_to_php "cd $work_dir_in_container; php 9douyu-module/artisan AccessTokenServer"
}

function to_php() {
    local cmd='bash'
    _send_cmd_to_php "cd $docker_code_root_dir; $cmd"
}

function _send_cmd_to_php() {
    local cmd=$1
    run_cmd "docker exec -it $php_container bash -c '$cmd'"
}

function run_php() {
    local cmd='run.sh run_dev'
    _run_php_container "$cmd"
}

function _run_php_container() {

    local args='--restart=always'
    # TODO
    # args="$args -v $prj_path/tmp/rsyslog.conf:/etc/rsyslog.d/rsyslog.conf"
    args="$args -v $app_log_dir:/var/log/php"
    args="$args -v $app_log_dir/crontab:/var/log/crontab"

    args="$args -v $prj_dir/crontab/crontab:/opt/crontab"
    args="$args -v $config_dir/php/conf/php-dev.ini:/usr/local/etc/php/php.ini"
    args="$args -v $config_dir/php/conf/php-fpm-dev.conf:/usr/local/etc/php-fpm.conf"

    args="$args -v $php_storage_dir/9douyu-core:$work_dir_in_container/9douyu-core/storage"
    args="$args -v $php_storage_dir/9douyu-module:$work_dir_in_container/9douyu-module/storage"
    args="$args -v $php_storage_dir/9douyu-service:$work_dir_in_container/9douyu-service/storage"

    args="$args -v $prj_dir:$work_dir_in_container"
    args="$args -w $work_dir_in_container"

    args="$args --link $mysql_container:mysql"
    args="$args --link $redis_container:redis-container"

    local cmd=$1
    run_cmd "docker run -d $args -h $php_container --name $php_container $php_base_image bash -c '$cmd'"
}

function _sudo_for_stroage() {
    local cmd=$1
    run_cmd "docker run --rm $docker_run_fg_mode -v $app_storage_dir:$app_storage_dir docker.sunfund.com/busybox sh -c '$cmd'"
}

function build_php_base_image() {
    docker build -t $php_base_image $apuppy_dir/docker/php-base/
}

function stop_php() {
    stop_container $php_container
}

function restart_php() {
    stop_php
    run_php
}

function to_php() {
    run_cmd "docker exec $docker_run_fg_mode $php_container bash -c 'cd $work_dir_in_container; bash'"
}

function to_mysql_env() {
    local cmd='bash'
    send_cmd_to_mysql_container "$cmd"
}

function import_mysql_data() {
    local cmd='cd apuppy/data/mysql-import/; for file in `ls */*`; do mysql -uroot --default-character-set=utf8 9dy_db < $file; done'
    send_cmd_to_mysql_container "$cmd"
}

function delete_mysql() {
    stop_mysql
    local cmd="rm -rf $mysql_data_dir"
    _sudo_for_stroage "$cmd"
}

function run_mysql() {
    local args="--restart always"

    args="$args -p $mysql_port:3306"

    args="$args -v $mysql_data_dir:/var/lib/mysql"

    # auto import data
    args="$args -v $apuppy_dir/data/mysql-init:/docker-entrypoint-initdb.d/"

    # config
    args="$args -v $config_dir/mysql/conf/:/etc/mysql/conf.d/"

    args="$args -v $app_log_dir/mysql/:/var/log/mysql/"

    args="$args -v $prj_dir:$work_dir_in_container"
    args="$args -w $work_dir_in_container"

    # do not use password
    args="$args -e MYSQL_ROOT_PASSWORD='' -e MYSQL_ALLOW_EMPTY_PASSWORD='yes'"
    run_cmd "docker run -d $args --name $mysql_container $mysql_image"

    _wait_mysql
}

function _wait_mysql() {
    local cmd="while ! mysqladmin ping -h 127.0.0.1 --silent; do sleep 1; done"
    send_cmd_to_mysql_container "$cmd"
}

function to_mysql() {
    local cmd='mysql -h 127.0.0.1 -P 3306 -u root -p 9dy_db'
    send_cmd_to_mysql_container "$cmd"
}

function send_cmd_to_mysql_container() {
    local cmd=$1
    run_cmd "docker exec $docker_run_fg_mode $mysql_container bash -c 'cd $work_dir_in_container; $cmd'"
}

function stop_mysql() {
    stop_container $mysql_container
}

function restart_mysql() {
    stop_mysql
    run_mysql
}

function run_redis() {
    local args="--restart always"
    args="$args -v $config_dir/redis/redis.conf:/usr/local/etc/redis/redis.conf"
    local cmd='redis-server /usr/local/etc/redis/redis.conf'
    run_cmd "docker run -d $args --name $redis_container $redis_image $cmd"
}

function stop_redis() {
    stop_container $redis_container
}

function to_redis() {
    local cmd='redis-cli'
    run_cmd "docker exec $docker_run_fg_mode $redis_container bash -c '$cmd'"
}

function restart_redis() {
    stop_redis
    run_redis
}

function run_nginx() {

    local nginx_data_dir="$apuppy_dir/nginx-data"
    local nginx_log_path="$app_log_dir/nginx"
    local args=$1

    args="--restart=always"

    args="$args -p $http_port:80"

    # nginx config
    args="$args -v $nginx_data_dir/conf/nginx.conf:/etc/nginx/nginx.conf"

    # for the other sites
    args="$args -v $nginx_data_dir/conf/extra/:/etc/nginx/extra"

    # logs
    args="$args -v $nginx_log_path:/var/log/nginx"
    args="$args -v $prj_dir:$work_dir_in_container"

    # generated nginx docker sites config
    args="$args -v $app_nginx_config_dir:/etc/nginx/docker-sites"

    args="$args --link $php_container:app"

    run_cmd "docker run -d $args --name $php_nginx_container $nginx_image"
}

function stop_nginx() {
    stop_container $php_nginx_container
}

function restart_nginx() {
    stop_nginx
    run_nginx
}

function _clean() {
    stop_nginx
    stop_php
    delete_mysql
    stop_redis
    local cmd="rm -rf $app_storage_dir/*"
    _sudo_for_stroage "$cmd"
}

function _clean_without_mysql() {
    stop_nginx
    stop_php
    stop_mysql
    stop_redis
    local cmd="rm -rf $app_storage_dir/runtime"
    _sudo_for_stroage "$cmd"
}

function clean() {
    _clean
}

function clean_without_mysql() {
   _clean_without_mysql 
}

function new_egg() {
    run_mysql
    build_code_config

    run_redis
    run_php
    run_nginx

    init_app
    import_mysql_data

    gen_token
}

function new_egg_without_mysql() {
    run_mysql
    build_code_config

    run_redis
    run_php
    run_nginx

    gen_token
}

function build_and_push_all_images() {
    build_and_push_php_related_images
    build_and_push_gateway_nginx_image
}

function build_and_push_php_image() {
    build_php_image
    push_php_image
}

function _build_code_to_php_related_context_dir() {
    local git_commit_id=$(git rev-parse HEAD);
    local dst_dir=$1
    local module_code_dir="$dst_dir/9douyu-module"
    local core_code_dir="$dst_dir/9douyu-core"
    local service_code_dir="$dst_dir/9douyu-service"
    run_cmd "cp -r $prj_dir/9douyu-module $module_code_dir"
    run_cmd "cp -r $prj_dir/9douyu-core $core_code_dir"
    run_cmd "cp -r $prj_dir/9douyu-service $service_code_dir"

    run_cmd "mv $core_code_dir/vendor $dst_dir/core-vendor"
    run_cmd "mv $module_code_dir/vendor $dst_dir/module-vendor"
    run_cmd "mv $service_code_dir/vendor $dst_dir/service-vendor"

    run_cmd "touch $module_code_dir/git_commit_id.$git_commit_id"
    run_cmd "touch $core_code_dir/git_commit_id.$git_commit_id"
    run_cmd "touch $service_code_dir/git_commit_id.$git_commit_id"
    local from=''
    local to=''

    # 9douyu-module: .env-prod.example
    from="$prj_dir/9douyu-module/.env-prod.example"
    to="$module_code_dir/.env"
    run_cmd "cp $from $to"

    from="$prj_dir/9douyu-module/config/cache-prod.example"
    to="$module_code_dir/config/cache.php"
    run_cmd "cp $from $to"

    from="$prj_dir/9douyu-module/config/oss-prod.example"
    to="$module_code_dir/config/oss.php"
    run_cmd "cp $from $to"

    # 9douyu-core: .env-prod.example
    from="$prj_dir/9douyu-core/.env-prod.example"
    to="$core_code_dir/.env"
    run_cmd "cp $from $to"

    from="$prj_dir/9douyu-core/config/cache-prod.example"
    to="$core_code_dir/config/cache.php"
    run_cmd "cp $from $to"

    # 9douyu-service: .env-prod.example
    from="$prj_dir/9douyu-service/.env-prod.example"
    to="$service_code_dir/.env"
    run_cmd "cp $from $to"
}

function build_php_image() {

    build_php_base_image

    local context_dir="$app_runtime_storage_dir/php-image"
    run_cmd "rm -rf $context_dir"
    ensure_dir $context_dir

    _build_code_to_php_related_context_dir $context_dir
    run_cmd "cp -r $apuppy_dir/docker/php-with-code/Dockerfile $context_dir/"
    run_cmd "cp -r $apuppy_dir/docker/php-with-code/rsyslogd.conf $context_dir/"
    run_cmd "cp -r $apuppy_dir/docker/php-with-code/supervisord.conf $context_dir/"
    run_cmd "cp -r $apuppy_dir/docker/php-with-code/9douyu.ini $context_dir/"
    run_cmd "cp -r $apuppy_dir/docker/php-base/conf/php-prod.ini $context_dir/"
    run_cmd "cp -r $prj_dir/crontab/crontab-prod $context_dir/"
    run_cmd "docker build -t $(_get_image_name php) $context_dir"
}

function build_php_nginx_image() {
    local context_dir="$app_runtime_storage_dir/php-nginx-image"
    run_cmd "rm -rf $context_dir"
    local nginx_docker_sites_dir="$context_dir/docker-sites"
    ensure_dir "$nginx_docker_sites_dir"

    _build_code_to_php_related_context_dir $context_dir

    run_cmd "cp $templates_dir/nginx-for-php/nginx.$env.conf $nginx_docker_sites_dir/app.conf"

    run_cmd "rm -rf $context_dir/9douyu-module/public/index.php"
    run_cmd "rm -rf $context_dir/9douyu-core/public/index.php"
    run_cmd "rm -rf $context_dir/9douyu-service/public/index.php"

    local config_key="docker"
    local config_file="$config_dir/deploy.yaml"
    local template_file="$templates_dir/nginx-for-php/fastcgi"
    local dst_file="$nginx_docker_sites_dir/fastcgi"
    local host_ip=$(docker0_ip)
    local extra_kv_list="php_fpm_port=$php_fpm_port host_ip=$host_ip"

    render_local_config $config_key $template_file $config_file $dst_file $extra_kv_list

    local tag="${image_tag:-latest}"
    run_cmd "cp -r $apuppy_dir/nginx-data/conf/nginx.conf $context_dir/"
    run_cmd "cp -r $apuppy_dir/docker/nginx-for-php/* $context_dir/"
    run_cmd "cp $prj_dir/crontab/crontab-php-nginx $context_dir/"
    run_cmd "docker build -t $(_get_image_name php-nginx) $context_dir"
}


function __push_image() {
    local name=$1
    image=$(_get_image_name $name)
    url=$(_get_image_publish_url $name)
    run_cmd "docker tag $image $url"
    run_cmd "docker push $url"
}

function push_gateway_nginx_image() {
    __push_image gateway-nginx
}

function push_php_nginx_image() {
    __push_image php-nginx
}

function push_php_image() {
    __push_image php
}


function push_php_base_image() {
    docker tag $php_base_image $php_base_image_push
    docker push $php_base_image_push
}


function build_and_push_php_related_images() {
    build_php_image
    build_php_nginx_image
    push_php_image
    push_php_nginx_image
}


function build_and_push_gateway_nginx_image() {
    build_gateway_nginx_image
    push_gateway_nginx_image
}

function build_and_push_php_nginx_image() {
    build_php_nginx_image
    push_php_nginx_image
}

function restart_php_related_images() {
    restart_php_image
    restart_php_nginx_image
}


function build_gateway_nginx_image() {

    local context_dir="$app_runtime_storage_dir/gateway-nginx-image"
    run_cmd "rm -rf $context_dir"
    local nginx_docker_sites_dir="$context_dir/docker-sites"
    ensure_dir $nginx_docker_sites_dir

    local config_key="docker"
    local config_file="$config_dir/deploy.yaml"
    local template_file="$templates_dir/nginx-for-gateway/nginx.$env.conf"
    local dst_file="$nginx_docker_sites_dir/app.conf"
    local extra_kv_list="php_nginx_port=$php_nginx_port"
    local host_ip=$(docker0_ip)
    extra_kv_list="$extra_kv_list host_ip=$host_ip"

    render_local_config $config_key $template_file $config_file $dst_file $extra_kv_list

    local tag="${image_tag:-latest}"
    run_cmd "cp -r $apuppy_dir/nginx-data/conf/nginx.conf $context_dir/"
    run_cmd "cp -r $apuppy_dir/docker/nginx-for-gateway/* $context_dir/"
    run_cmd "cp $prj_dir/crontab/crontab-gateway-nginx $context_dir/"
    run_cmd "docker build -t $(_get_image_name gateway-nginx) $context_dir"
}

_get_image_name() {
    local name=$1
    local tag="${image_tag:-latest}"
    local branch="${branch_name:-master}"
    local image_name="docker.sunfund.com/9dy/$name-$env-$branch:$tag"
    echo $image_name
}

_get_image_publish_url() {
    local name=$1
    local tag="${image_tag:-latest}"
    local branch="${branch_name:-master}"
    local image_name="docker-publish.sunfund.com/9dy/$name-$env-$branch:$tag"
    echo $image_name
}

function run_php_image() {
    local args="--restart always"
    local host=`hostname`

	ensure_dir "$php_storage_dir/9douyu-core/logs"
    ensure_dir "$php_storage_dir/9douyu-module/logs"
    ensure_dir "$php_storage_dir/9douyu-module/framework/sessions"
    ensure_dir "$php_storage_dir/9douyu-module/framework/cache"
    ensure_dir "$php_storage_dir/9douyu-service/logs"
    args="$args --cap-add SYS_PTRACE"
    args="$args --privileged"
    args="$args -h $host"

    args="$args -p $php_fpm_port:9000"
    args="$args -v $app_log_dir/php:/var/log/php"
    args="$args -v $app_log_dir/crontab:/var/log/crontab"

	args="$args -v $php_storage_dir/9douyu-core:$work_dir_in_container/9douyu-core/storage"
    args="$args -v $php_storage_dir/9douyu-module:$work_dir_in_container/9douyu-module/storage"
    args="$args -v $php_storage_dir/9douyu-service:$work_dir_in_container/9douyu-service/storage"

    args="$args -w $work_dir_in_container"

    local image_name=$(_get_image_name php)
    local cmd='run.sh'
    run_cmd "docker run -d $args --name $php_container $image_name $cmd"

    #_save_hosts $php_container
}

_save_hosts() {
    local php_container=$1
    local host_ip=$(docker0_ip)
    local hosts="$host_ip    core-pre.jiudouyu.com service-pre.jiudouyu.com core.jiudouyu.com service.jiudouyu.com"
    hosts="$hosts core-pre.9douyu.com service-pre.9douyu.com core.9douyu.com service.9douyu.com"

    run_cmd "docker exec $php_container bash -c 'echo $hosts >> /etc/hosts'"
}

function run_php_schedule_image() {
    local args="--restart always"
    local host=`hostname`

	ensure_dir "$php_storage_dir/9douyu-core/logs"
    ensure_dir "$php_storage_dir/9douyu-module/logs"
    ensure_dir "$php_storage_dir/9douyu-module/framework/sessions"
    ensure_dir "$php_storage_dir/9douyu-module/framework/cache"
    ensure_dir "$php_storage_dir/9douyu-service/logs"
    args="$args --cap-add SYS_PTRACE"
    args="$args -h $host"

    args="$args -p $php_schedule_port:9000"
    args="$args -v $app_log_dir:/var/log/php"
    args="$args -v $app_log_dir/crontab:/var/log/crontab"

	args="$args -v $php_storage_dir/9douyu-core:$work_dir_in_container/9douyu-core/storage"
    args="$args -v $php_storage_dir/9douyu-module:$work_dir_in_container/9douyu-module/storage"
    args="$args -v $php_storage_dir/9douyu-service:$work_dir_in_container/9douyu-service/storage"

    args="$args -w $work_dir_in_container"

    local image_name=$(_get_image_name php)
    local cmd='run.sh run_prod'
    run_cmd "docker run -d $args --name $php_schedule_container $image_name $cmd"

    #_save_hosts $php_schedule_container
}

function stop_php_image() {
    stop_container $php_container
}

function stop_php_schedule_image() {
    stop_container $php_schedule_container
}

function restart_php_image() {
    local image_name=$(_get_image_name php)
    run_cmd "docker pull $image_name"
    stop_php_image
    run_php_image
}

function restart_php_schedule_image() {
    local image_name=$(_get_image_name php)
    run_cmd "docker pull $image_name"
    stop_php_schedule_image
    run_php_schedule_image
}

function run_gateway_nginx_image() {
    local args='--restart=always'
    args="$args -p $app_http_port:80"
    args="$args -p 80:80"
    args="$args -p $app_https_port:443"
    args="$args -p 443:443"
    args="$args -v $app_log_dir/nginx:/var/log/nginx"
    args="$args -v $app_log_dir/crontab/archive_gateway_nginx.log:/var/log/crontab/archive_gateway_nginx.log"

    local image_name=$(_get_image_name gateway-nginx)

    local cmd='run.sh'
    run_cmd "docker run -d $args --name $gateway_nginx_container $image_name $cmd"
}

function stop_gateway_nginx_image() {
    stop_container $gateway_nginx_container
}

function restart_gateway_nginx_image() {
    local image_name=$(_get_image_name gateway-nginx)
    run_cmd "docker pull $image_name"
    stop_gateway_nginx_image
    run_gateway_nginx_image
}

function run_php_nginx_image() {
    local args='--restart=always'
    args="$args -p $php_nginx_port:80"
    args="$args -v $app_log_dir/nginx:/var/log/nginx"
    args="$args -v $app_log_dir/crontab/archive_php_nginx.log:/var/log/crontab/archive_php_nginx.log"

    local image_name=$(_get_image_name php-nginx)
    local cmd='run.sh'
    run_cmd "docker run -d $args --name $php_nginx_container $image_name $cmd" 
}

function stop_php_nginx_image() {
    stop_container $php_nginx_container
}

function restart_php_nginx_image() {
    local image_name=$(_get_image_name php-nginx)
    run_cmd "docker pull $image_name"
    stop_php_nginx_image
    run_php_nginx_image
}

function restart_all_on_this_node() {
    restart_php_image
    restart_php_nginx_image
    restart_gateway_nginx_image
}

function stop_all() {
    stop_php_nginx_image
    stop_php_image
    stop_gateway_nginx_image
}

function start_all() {
    run_php_nginx_image
    run_php_image
    run_gateway_nginx_image
}

function py() {
    shift
    local cmd="$@"
    run_cmd "python $apuppy_dir/devops/src/app.py $cmd"
}


function help() {
	cat <<-EOF
    
    Usage: mamanger.sh [options]
            
        Valid options are:

            init_dev
            
            clean
            clean_without_mysql
            new_egg
            new_egg_without_mysql
            run
            stop
            restart
            
            run_mysql
            to_mysql
            to_mysql_env
            stop_mysql
            restart_mysql
            delete_mysql

            run_redis
            to_redis
            stop_redis
            restart_redis

            run_php

            run_nginx
            stop_nginx
            restart_nginx

            build_php_base_image
            push_php_base_image

            run_php
            stop_php
            restart_nginx
            to_php

------------------  deploy  ------------------

            build_php_image
            build_php_nginx_image
            build_gateway_nginx_image

            push_php_image
            push_php_nginx_image
            push_gateway_nginx_image

            build_and_push_php_image
            build_and_push_php_nginx_image
            build_and_push_gateway_nginx_image

            build_and_push_all_images

            run_php_image
            stop_php_image
            restart_php_image

            run_php_schedule_image
            stop_php_schedule_image
            restart_php_schedule_image

            run_php_nginx_image
            stop_php_nginx_image
            restart_php_nginx_image

            run_gateway_nginx_image
            stop_gateway_nginx_image
            restart_gateway_nginx_image
            
            do_init_for_deploy
            load_config_for_deploy

            restart_all_on_this_node
            stop_all
            start_all

            help                      show this help message and exit

EOF
}
if [ -z "$action" ]; then
    action='help'
fi
$action "$@"
