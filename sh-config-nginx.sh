#!/usr/bin/env bash

if [[ -a nginx/conf.d/${APP_NAME}-${ENVIRONMENT}.conf ]]; then
	rm -f nginx/conf.d/${APP_NAME}-${ENVIRONMENT}.conf
fi

cat <<EOF > nginx/conf.d/${APP_NAME}-${ENVIRONMENT}.conf
server {
    server_name lapshin.loc www.lapshin.loc;
    root /var/www/html/${APP_NAME}/public;

    location / {
        try_files \$uri /index.php\$is_args\$args;
    }

    location ~ ^/index\.php(/|$) {
        fastcgi_pass php:${PHP_PORT};
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        include fastcgi_params;

        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        fastcgi_param DOCUMENT_ROOT \$realpath_root;
        internal;
    }

    location ~ \.php$ {
        return 404;
    }

    error_log /var/log/nginx/symfony_error.log;
    access_log /var/log/nginx/symfony_access.log;
}
EOF