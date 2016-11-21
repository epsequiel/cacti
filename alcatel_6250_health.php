<?php

# (c)2016/11, Ezequiel Meinero
# Extraigo valores de funcionamiento de switch Alcatel 6250
# La diferencia con el 6850 es que es stackeable y tengo que 
# medir maximos y promediar
# CPU Last (max del stack)
# CPU Last (promedio del stack)
# CPU Max en 1 hora (max del stack)
# Mem Last (max del stack)
# Rx/Tx Max en 1 hora (max del stack)
 
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

# CPU params
$switch_cpu_max = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "HealthModuleCPU", $snmp_timeout, $snmp_retries);

$switch_cpu_last = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "HealthModuleCPULatest", $snmp_timeout, $snmp_retries);

$switch_mem_last = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "HealthModuleMemoryLatest", $snmp_timeout, $snmp_retries);

# Rx/Tx Latest
$switch_rxtx_last = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "HealthModuleRxTxLatest", $snmp_timeout, $snmp_retries);

# Rx/Tx Max
$switch_rxtx_max = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "HealthModuleRxTx", $snmp_timeout, $snmp_retries);

# System info
$sysinfo = @snmp3_walk($snmp_hostname, $snmp_community, "authNoPriv", "SHA", "b8LTlnuna", "","", "system", $snmp_timeout, $snmp_retries);
# 

# Resultados
$sw_cpu_last_max 	= max($switch_cpu_last);
$sw_cpu_last_prom	= array_sum($switch_cpu_last)/count($switch_cpu_last);
$sw_cpu_1hr_max		= max($switch_cpu_max);
$sw_mem_latest 		= max($switch_mem_last);
$sw_rxtx_last		= max($switch_rxtx_last);
$sw_rxtx_max		= max($switch_rxtx_max);
$sw_mod_cnt		= count($switch_cpu_max);
$sw_info 		= $sysinfo[0];

# Con sw_info
#print "sw_cpu_last_max:$sw_cpu_last_max sw_cpu_last_prom:$sw_cpu_last_prom sw_cpu_1hr_max:$sw_cpu_1hr_max sw_mem_latest:$sw_mem_latest sw_rxtx_last:$sw_rxtx_last sw_rxtx_max:$sw_rxtx_max sw_mod_cnt:$sw_mod_cnt sw_info:$sw_info";

# Sin sw_info
print "sw_cpu_last_max:$sw_cpu_last_max sw_cpu_last_prom:$sw_cpu_last_prom sw_cpu_1hr_max:$sw_cpu_1hr_max sw_mem_latest:$sw_mem_latest sw_rxtx_last:$sw_rxtx_last sw_rxtx_max:$sw_rxtx_max sw_mod_cnt:$sw_mod_cnt";

?>
