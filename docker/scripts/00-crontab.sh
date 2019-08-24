echo "* * * * * su -s /bin/bash -c '/usr/local/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1' nginx"  >> /var/spool/cron/crontabs/root
/usr/sbin/crond
