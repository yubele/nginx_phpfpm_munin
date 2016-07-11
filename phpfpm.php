#!/usr/bin/php
<?php

echo('graph_title nginx phpfpm status'."\n");
echo('graph_vlabel conn/processes'."\n");
echo('graph_scale no'."\n");
echo('graph_info NGINX & php-fpm status'."\n");
echo('graph_category nginx'."\n");

$phpfpm = ["max listen queue",
	"listen queue len",
	"idle processes",
	"active processes",
	"total processes",
	"max active processes",
	"max children reached",
	"slow requests"];

$i=0;
foreach($phpfpm as $label) {
  $status = chop(`wget 127.0.0.1/phpfpm_status -O - -q | egrep -e "^$label:" | cut -f2 -d: |awk '{print $1}'`);
  $replacement_label = preg_replace("#\s#", '_', $label);
  echo("$replacement_label.label ".$replacement_label."\n");
  echo("$replacement_label.value ".$status."\n");
  echo($replacement_label.'.type Gauge'."\n");
  echo($replacement_label.'.info '.$label."\n");
  echo($replacement_label.'.min 0'."\n");
}
