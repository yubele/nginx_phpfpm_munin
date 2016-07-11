#!/usr/bin/php
<?php

echo('graph_title phpfpm accepted conn.'."\n");
echo('graph_vlabel conn'."\n");
echo('graph_scale no'."\n");
echo('graph_info php-fpm accepted conn.'."\n");
echo('graph_category nginx'."\n");


$phpfpm[0] = "accepted conn";

$i=0;
foreach($phpfpm as $label) {
  $status = chop(`wget 127.0.0.1/phpfpm_status -O - -q | egrep -e "^$label:" | cut -f2 -d: |awk '{print $1}'`);
  $replacement_label = preg_replace("#\s#", '_', $label);
  echo("$replacement_label.label ".$replacement_label."\n");
  echo("$replacement_label.value ".$status."\n");
  echo($replacement_label.'.type GAUGE'."\n");
  echo($replacement_label.'.info '.$label."\n");
  echo($replacement_label.'.min 0'."\n");
}
