#!/usr/bin/php
<?php
$netstat = shell_exec('/bin/netstat -ntap | grep SYN_RECV | awk \'{split($5,a,":"); print a[1]}\' | sort | uniq -c | awk \'{print $2,$1}\'');
//$netstat = shell_exec('/bin/netstat -ntap | grep ESTABLISHED | awk \'{split($5,a,":"); print a[1]}\' | sort | uniq -c | awk \'{print $2,$1}\'');
$lines = preg_split('/[\n]+/', $netstat);

foreach($lines as $line) {
    $fields = preg_split('/\s+/', $line);
    $ip = $fields[0];
    if(!empty($ip)) {
        $hits = $fields[1];
        if($hits > 20) {
            exec("/sbin/iptables -A INPUT -s ".escapeshellarg($ip)." -j DROP");
            var_dump('exec /sbin/iptables -A INPUT -s '.escapeshellarg($ip).' -j DROP');
        }
    }
}
?>
