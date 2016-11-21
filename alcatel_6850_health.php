<?php

# (c)2016/11, Ezequiel Meinero
# Extraigo valores de funcionamiento de switch Alcatel 6850
# CPU Last 
# CPU Max en 1 hora
# Mem Last
# Rx/Tx Max en 1 hora
 
/* do NOT run this script through a web browser */
if (!isset($_SERVER["argv"][0]) || isset($_SERVER['REQUEST_METHOD'])  || isset($_SERVER['REMOTE_ADDR'])) {
   die("<br><strong>This script is only meant to run at the command line.</strong>");
}

# deactivate http headers
$no_http_headers = true;

# params
$snmp_hostname  = $argv[1];         #hostname
$snmp_community = $argv[2];         #community string
#$sec_name       = $argv[3];         #security name, usually some kind of username
#$sec_level      = $argv[4];         #the security level (noAuthNoPriv|authNoPriv|authPriv)
#$auth_protocol  = $argv[5];         #MD5 or SHA
#$auth_passphrase= $argv[6];         #authentication pass phrase
#$priv_protocol  = $argv[7];         #privacy protocol (DES or AES)
#$priv_passphrase= $argv[8];         #privacy pass phrase
#$object_id      = $argv[9]          #OID
$snmp_timeout   = 500000;           #snmp timeout useconds
$snmp_retries   = 2;                #snmp retries
# 
#
snmp_set_valueretrieval(SNMP_VALUE_PLAIN);
$switch = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "healthmoduleentry", $snmp_timeout, $snmp_retries);
$sysinfo = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "system", $snmp_timeout, $snmp_retries);
# 

# Resultados
$sw_cpu_latest 	= $switch[13];
$sw_cpu_1hr_max = $switch[16];
$sw_mem_latest 	= $switch[9];
$sw_rxtx_latest = $switch[5];
$sw_info 	= $sysinfo[0];

print "sw_cpu_latest:$sw_cpu_latest sw_cpu_1hr_max:$sw_cpu_1hr_max sw_mem_latest:$sw_mem_latest sw_rxtx_latest:$sw_rxtx_latest"

?>
