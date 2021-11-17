
## Требования

- redis, default settings
- node v12+
- php 7.3+, basic laravel extensions
- libreoffice, pdftoppm (apt install libreoffice-common;apt install poppler-utils)
- supervisor

## Как запустить

- composer install
- npm install
- npm install - g laravel-echo-server
- php artisan migrate
- настросить supervisor

```cd /etc/supervisor/conf.d/ ```
``` 
echo-server.conf:
[program:echo-server]
process_name=%(program_name)s_%(process_num)04d
command=/usr/bin/node /usr/local/bin/laravel-echo-server start --dir=/home/zconvert/app
autostart=true
autorestart=true
user=zconvert
redirect_stderr=true
```

``` 
laravel-worker.conf :
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /home/zconvert/app/artisan queue:work database --sleep=3 --tries=2 --daemon
autostart=true
autorestart=true
user=zconvert
numprocs=8
redirect_stderr=true
stdout_logfile=/var/log/laravel-worker.log
```

Файлы, где поправить порты laravel echo:
./public/js/app.js:
./resources/js/bootstrap.js
./app/laravel-echo-server.json
- После редактирования: npm run dev

- sudo supervisorctl reread
- sudo supervisorctl update
- sudo supervisorctl restart all

- iptables -A INPUT -p tcp -m tcp --dport ПОРТ-LARAVEL-ECHO -j ACCEPT 

- .env
``` 
CACHE_DRIVER = file
SESSION_DRIVER = file
```

- php artisan cache:clear
- php artisan config:clear

## Крон 
- * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1


## Misc

- нужно ли, чтоб libreoffice работал как сервер? - нет
- в какую папку складываются файлы, которые подгружаются и потом конвертируются? - storage/app/public

## Add to website apache config (asuming 2099 is a laravel echo port)

ewriteEngine On
RewriteCond %{REQUEST_URI}  ^/socket.io            [NC]
RewriteCond %{QUERY_STRING} transport=websocket    [NC]
RewriteRule /(.*)           ws://localhost:2099/$1 [P,L]

ProxyPass        /socket.io http://localhost:2099/socket.io
ProxyPassReverse /socket.io http://localhost:2099/socket.io 
IPCCommTimeout 31



