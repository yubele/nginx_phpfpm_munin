#!/usr/bin/php
<?php

echo('graph_title nginx active connection'."\n");
echo('graph_vlabel active connection from nginx stub_status'."\n");
echo('graph_scale no'."\n");
echo('graph_info NGINX & php-fpm status'."\n");
echo('graph_category nginx'."\n");

$label = 'Active connections';
$info = 'The current number of active client connections including Waiting connections.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "^$label" | cut -f2 -d: |awk '{print $1}'`);
echo_label($label, $info, $status);

function echo_label($label, $info, $status) {
  echo($label.".label ".$label."\n");
  echo($label.".value ".$status."\n");
  echo($label.'.type GAUGE'."\n");
  echo($label.'.info '.$label."\n");
  echo($label.'.min 0'."\n");
}
