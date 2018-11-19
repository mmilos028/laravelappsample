<?php
//phpinfo();
//die();
/**
 script test modules present with php configuration
 */
$presentModules = array(); //if module is loaded
$notPresentModules = array(); //if module is not loaded
$allListedModules = array(); //if module is listed from dev environment
$requiredModules = array( //if module is required by application environment
    "curl", "date", "dom", "gd", "json",
    "oci8", "SimpleXML", "libxml", "soap", "sockets", "imap",
    "Reflection", "calendar", "ctype", "filter", "ftp", "hash",
    "iconv", "mcrypt", "openssl", "pcre", "session",
    "standard", "tokenizer", "wddx", "xmlreader", "xmlwriter","zip", "zlib",
    //
);

$allListedModules[] = "bz2";
if(extension_loaded('bz2')){
    $presentModules[] = "bz2";
}else{
    $notPresentModules[] = "bz2";
}
$allListedModules[] = "calendar";
if(extension_loaded('calendar')){
    $presentModules[] = "calendar";
}else{
    $notPresentModules[] = "calendar";
}
$allListedModules[] = "ctype";
if(extension_loaded('ctype')){
    $presentModules[] = "ctype";
}else{
    $notPresentModules[] = "ctype";
}
$allListedModules[] = "curl";
if(extension_loaded('curl')){
    $presentModules[] = "curl";
}else{
    $notPresentModules[] = "curl";
}
$allListedModules[] = "date";
if(extension_loaded('date')){
    $presentModules[] = "date";
}else{
    $notPresentModules[] = "date";
}
$allListedModules[] = "dom";
if(extension_loaded('dom')){
    $presentModules[] = "dom";
}else{
    $notPresentModules[] = "dom";
}
$allListedModules[] = "exif";
if(extension_loaded('exif')){
    $presentModules[] = "exif";
}else{
    $notPresentModules[] = "exif";
}
$allListedModules[] = "filter";
if(extension_loaded('filter')){
    $presentModules[] = "filter";
}else{
    $notPresentModules[] = "filter";
}
$allListedModules[] = "ftp";
if(extension_loaded('ftp')){
    $presentModules[] = "ftp";
}else{
    $notPresentModules[] = "ftp";
}
$allListedModules[] = "gd";
if(extension_loaded('gd')){
    $presentModules[] = "gd";
}else{
    $notPresentModules[] = "gd";
}
$allListedModules[] = "gettext";
if(extension_loaded('gettext')){
    $presentModules[] = "gettext";
}else{
    $notPresentModules[] = "gettext";
}
$allListedModules[] = "gmp";
if(extension_loaded('gmp')){
    $presentModules[] = "gmp";
}else{
    $notPresentModules[] = "gmp";
}
$allListedModules[] = "hash";
if(extension_loaded('hash')){
    $presentModules[] = "hash";
}else{
    $notPresentModules[] = "hash";
}
$allListedModules[] = "iconv";
if(extension_loaded('iconv')){
    $presentModules[] = "iconv";
}else{
    $notPresentModules[] = "iconv";
}
$allListedModules[] = "json";
if(extension_loaded('json')){
    $presentModules[] = "json";
}else{
    $notPresentModules[] = "json";
}
$allListedModules[] = "ldap";
if(extension_loaded('ldap')){
    $presentModules[] = "ldap";
}else{
    $notPresentModules[] = "ldap";
}
$allListedModules[] = "libxml";
if(extension_loaded('libxml')){
    $presentModules[] = "libxml";
}else{
    $notPresentModules[] = "libxml";
}
$allListedModules[] = "mcrypt";
if(extension_loaded('mcrypt')){
    $presentModules[] = "mcrypt";
}else{
    $notPresentModules[] = "mcrypt";
}
$allListedModules[] = "oci8";
if(extension_loaded('oci8')){
    $presentModules[] = "oci8";
}else{
    $notPresentModules[] = "oci8";
}
$allListedModules[] = "openssl";
if(extension_loaded('openssl')){
    $presentModules[] = "openssl";
}else {
    $notPresentModules[] = "openssl";
}
$allListedModules[] = "pcntl";
if(extension_loaded('pcntl')){
    $presentModules[] = "pcntl";
}else{
    $notPresentModules[] = "pcntl";
}
$allListedModules[] = "pcre";
if(extension_loaded('pcre')){
    $presentModules[] = "pcre";
}else{
    $notPresentModules[] = "pcre";
}
$allListedModules[] = "posix";
if(extension_loaded('posix')){
    $presentModules[] = "posix";
}else{
    $notPresentModules[] = "posix";
}
$allListedModules[] = "readline";
if(extension_loaded('readline')){
    $presentModules[] = "readline";
}else{
    $notPresentModules[] = "readline";
}
$allListedModules[] = "Reflection";
if(extension_loaded('Reflection')){
    $presentModules[] = "Reflection";
}else{
    $notPresentModules[] = "Reflection";
}
$allListedModules[] = "session";
if(extension_loaded('session')){
    $presentModules[] = "session";
}else{
    $notPresentModules[] = "session";
}
$allListedModules[] = "shmop";
if(extension_loaded('shmop')){
    $presentModules[] = "shmop";
}else{
    $notPresentModules[] = "shmop";
}
$allListedModules[] = "SimpleXML";
if(extension_loaded('SimpleXML')){
    $presentModules[] = "SimpleXML";
}else{
    $notPresentModules[] = "SimpleXML";
}
$allListedModules[] = "soap";
if(extension_loaded('soap')){
    $presentModules[] = "soap";
}else{
    $notPresentModules[] = "soap";
}
$allListedModules[] = "sockets";
if(extension_loaded('sockets')){
    $presentModules[] = "sockets";
}else{
    $notPresentModules[] = "sockets";
}
$allListedModules[] = "SPL";
if(extension_loaded('SPL')){
    $presentModules[] = "SPL";
}else{
    $notPresentModules[] = "SPL";
}
$allListedModules[] = "standard";
if(extension_loaded('standard')){
    $presentModules[] = "standard";
}else{
    $notPresentModules[] = "standard";
}
$allListedModules[] = "sysvmsg";
if(extension_loaded('sysvmsg')){
    $presentModules[] = "sysvmsg";
}else{
    $notPresentModules[] = "sysvmsg";
}
$allListedModules[] = "sysvsem";
if(extension_loaded('sysvsem')){
    $presentModules[] = "sysvsem";
}else{
    $notPresentModules[] = "sysvsem";
}
$allListedModules[] = "sysvshm";
if(extension_loaded('sysvshm')){
    $presentModules[] = "sysvshm";
}else{
    $notPresentModules[] = "sysvshm";
}
$allListedModules[] = "tokenizer";
if(extension_loaded('tokenizer')){
    $presentModules[] = "tokenizer";
}else{
    $notPresentModules[] = "tokenizer";
}
$allListedModules[] = "wddx";
if(extension_loaded('wddx')){
    $presentModules[] = "wddx";
}else{
    $notPresentModules[] = "wddx";
}
$allListedModules[] = "xml";
if(extension_loaded('xml')){
    $presentModules[] = "xml";
}else{
    $notPresentModules[] = "xml";
}
$allListedModules[] = "xmlreader";
if(extension_loaded('xmlreader')){
    $presentModules[] = "xmlreader";
}else{
    $notPresentModules = "xmlreader";
}
$allListedModules[] = "xmlwriter";
if(extension_loaded('xmlwriter')){
    $presentModules[] = "xmlwriter";
}else{
    $notPresentModules[] = "xmlwriter";
}
$allListedModules[] = "xsl";
if(extension_loaded('xsl')){
    $presentModules[] = "xsl";
}else{
    $notPresentModules[] = "xsl";
}
$allListedModules[] = "zip";
if(extension_loaded('zip')){
    $presentModules[] = "zip";
}else{
    $notPresentModules[] = "zip";
}
$allListedModules[] = "zlib";
if(extension_loaded('zlib')){
    $presentModules[] = "zlib";
}else{
    $notPresentModules[] = "zlib";
}

$allListedModules[] = "imap";
if(extension_loaded('imap')){
    $presentModules[] = "imap";
}else{
    $notPresentModules[] = "imap";
}

$loadedModules = get_loaded_extensions();
sort($presentModules);
sort($notPresentModules);
sort($loadedModules);

echo "<br /> <b> PHP VERSION: </b> " . phpversion() . "<br />";

echo "<br /> <b>PRESENT MODULES:</b> ";
foreach($presentModules as $present){
    echo "<br />" . strtoupper($present);
}

echo "<br /> <br /> <br /> <b>NOT PRESENT MODULES:</b> ";
foreach($notPresentModules as $notpresent){
    echo "<br /> " . strtoupper($notpresent);
}

echo "<br /> <br /> <br /> <b>REQUIRED - BUT NOT PRESENT MODULES:</b> ";
$requiredNotPresentModules = array_intersect($requiredModules, $notPresentModules);
foreach($requiredNotPresentModules as $notpresent){
    echo "<br /> " . strtoupper($notpresent);
}

echo "<br /> <br /> <br /> <b>ALL LOADED MODULES BY PHP</b>";
foreach($loadedModules as $loaded){
    echo "<br /> " . strtoupper($loaded);
}
