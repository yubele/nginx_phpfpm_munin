#!/usr/bin/php
<?php

echo('graph_title nginx request status'."\n");
echo('graph_vlabel server accepts handled requests from nginx stub_status'."\n");
echo('graph_scale no'."\n");
echo('graph_info NGINX & php-fpm status'."\n");
echo('graph_category nginx'."\n");

$label = 'accepts';
$info = 'The total number of accepted client connections.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "$label" -A1 | tail -n 1 |awk '{print $1}' `);
echo_label($label, $info, $status);

$label = 'handled';
$info = 'The total number of accepted client connections.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "$label" -A1 | tail -n 1 |awk '{print $2}' `);
echo_label($label, $info, $status);

$label = 'requests';
$info = 'The total number of client requests.';
$status = chop(`wget 127.0.0.1/nginx_status -O - -q | egrep -e "$label" -A1 | tail -n 1 |awk '{print $3}' `);
echo_label($label, $info, $status);

function echo_label($label, $info, $status) {
  $replacement_label = str_replace(' ', '_', $label);
  echo($replacement_label.".label ".$label."\n");
  echo($replacement_label.".value ".$status."\n");
  echo($replacement_label.'.type GAUGE'."\n");
  echo($replacement_label.'.info '.$label."\n");
  echo($replacement_label.'.min 0'."\n");
}
