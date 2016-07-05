#!/usr/bin/php
<?php

echo('graph_title nginx phpfpm status'."\n");
echo('graph_vlabel conn/processes'."\n");
echo('graph_scale no'."\n");
echo('graph_info NGINX & php-fpm status'."\n");
echo('graph_category nginx'."\n");

$phpfpm[0] = "accepted conn";
$phpfpm[1] = "max listen queue";
$phpfpm[2] = "listen queue len";
$phpfpm[3] = "idle processes";
$phpfpm[4] = "active processes";
$phpfpm[5] = "total processes";
$phpfpm[6] = "max active processes";
$phpfpm[7] = "max children reached";
$phpfpm[8] = "slow requests";

#nginx[0]="Active connections"
#up.label bps
#up.type DERIVE
#up.negative down
#up.cdef up,8,*

$i=0;
foreach($phpfpm as $label) {
  $status = chop(`wget 127.0.0.1/phpfpm_status -O - -q | egrep -e "^$label:" | cut -f2 -d: |awk '{print $1}'`);
  $replacement_label = preg_replace("#\s#", '_', $label);
  echo("$replacement_label.label ".$replacement_label."\n");
  echo("$replacement_label.value ".$status."\n");
  echo($replacement_label.'.type DERIVE'."\n");
  echo($replacement_label.'.info '.$label."\n");
  echo($replacement_label.'.min 0'."\n");
}

#wget 127.0.0.1/phpfpm_status -O - -q | grep "max children reached" | cut -f2 -d: |awk '{print $1}'
