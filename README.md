
## Требования

- redis, default settings
- node v12+
- php 7.3+, basic laravel extensions
- libreoffice, pdftoppm (apt install libreoffice-common;apt install poppler-utils)
- supervisor

## Как запустить

- composer install
- npm install
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

- sudo supervisorctl reread
- sudo supervisorctl update
- sudo supervisorctl restart laravel-worker:*

- .env
``` 
CACHE_DRIVER = file
SESSION_DRIVER = file
```

- php artisan cache:clear
- php artisan config:clear



