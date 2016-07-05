
Munin Plugin for Nginx+PHP FPM
============

Installasion
-----------
1. Set up the status page of `nginx (stub_status), phpfpm (pm.status)`.
 https://nginx.org/en/docs/http/ngx_http_stub_status_module.html
 http://php.net/manual/en/install.fpm.configuration.php
2. Install to /etc/munin-node/plugins

Sample
-----------
$ cat /etc/nginx/site-enabled/sample.com
http {
  ....

  location /phpfpm_status {
    access_log   off;
    allow 127.0.0.1;
    deny all;
    include         fastcgi_params;
    #fastcgi_pass    127.0.0.1:9000;
    fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    fastcgi_index   index.php;
    fastcgi_connect_timeout 13s;
    fastcgi_param   PATH_INFO         $fastcgi_path_info;
    fastcgi_param   SCRIPT_FILENAME   $document_root$fastcgi_script_name;
  }
  location /nginx_status {
    stub_status on;
    access_log   off;
    allow 127.0.0.1;
    deny all;
  }
}

$ cat ***/www.conf
...

pm.status_path = /phpfpm_status