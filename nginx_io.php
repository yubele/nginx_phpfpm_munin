#!/usr/bin/php
<?php

echo('graph_title nginx io status'."\n");
echo('graph_vlabel io status from nginx stub_status'."\n");
echo('graph_scale no'."\n");
echo('graph_info NGINX & php-fpm status'."\n");
echo('graph_category nginx'."\n");

$label = 'Reading';
$info = 'The current number of connections where nginx is reading the request header.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "^$label" |awk '{print $2}' `);
echo_label($label, $info, $status);

$label = 'Writing';
$info = 'The current number of connections where nginx is writing the response back to the client.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "$label" |awk '{print $4}'`);
echo_label($label, $info, $status);

$label = 'Waiting';
$info = 'The current number of idle client connections waiting for a request.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "$label" |awk '{print $6}'`);
echo_label($label, $info, $status);

function echo_label($label, $info, $status) {
  echo($label.".label ".$label."\n");
  echo($label.".value ".$status."\n");
  echo($label.'.type Gauge'."\n");
  echo($label.'.info '.$label."\n");
  echo($label.'.min 0'."\n");
}
