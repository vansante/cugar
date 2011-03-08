<?php

class OpenSSLCertificate {

    private $name;

    public function __construct($cert_name) {
        $this->name = $cert_name;
    }

    public function exists() {
        $base_file_path = $cert_dir.DIRECTORY_SEPARATOR.$cert_name;

        $file_exist_count = 0;
        if (file_exists($base_file_path.'.crt')) {
            $file_exist_count++;
        }
        if (file_exists($base_file_path.'.key')) {
            $file_exist_count++;
        }
        return $file_exist_count == 2;
    }

    public function generateNew() {

        $cert_name = $this->name;
        $cert_dir = csSettings::get('certificate_dir');

        if ($this->exists()) {
            return false;
        }

        $openssl_cnf = csSettings::get('openssl_cnf_path');
        if (!file_exists($openssl_cnf)) {
            throw new sfException("Couldn't find openssl.cnf at '".$openssl_cnf."'");
        }
        if (!is_readable($openssl_cnf)) {
            throw new sfException("Couldn't read openssl.cnf at '".$openssl_cnf."'");
        }

        $ca_file = $cert_dir.DIRECTORY_SEPARATOR.'ca.crt';
        if (!file_exists($ca_file)) {
            throw new sfException("Couldn't find certificate of authority at '".$ca_file."'");
        }
        if (!is_readable($ca_file)) {
            throw new sfException("Couldn't read certificate of authority at '".$ca_file."'");
        }
        $ca_key_file = $cert_dir.DIRECTORY_SEPARATOR.'ca.key';
        if (!file_exists($ca_key_file)) {
            throw new sfException("Couldn't find certificate of authority at '".$ca_key_file."'");
        }
        if (!is_readable($ca_key_file)) {
            throw new sfException("Couldn't read certificate of authority at '".$ca_key_file."'");
        }

        // Code borrowed from: http://www.php.net/manual/en/function.openssl-pkey-new.php
        $dn = array(
            "countryName" => csSettings::get('cert_key_country_code'),
            "stateOrProvinceName" => csSettings::get('cert_key_province_code'),
            "localityName" => csSettings::get('cert_key_city'),
            "organizationName" => csSettings::get('cert_key_organisation'),
            "organizationalUnitName" => csSettings::get('cert_key_organisation_unit'),
            "commonName" => $cert_name,
            "emailAddress" => csSettings::get('cert_key_email')
        );
        $config = array(
            'config' => csSettings::get('openssl_cnf_path'),
            'private_key_bits' => 1024,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'encrypt_key' => false
        );

        $privkeypass = csSettings::get('cert_pass_key');
        $numberofdays = csSettings::get('cert_crt_expire_days');

        $privkey = openssl_pkey_new($config);
        if ($privkey === false) {
            $this->printOpenSSLError('openssl_pkey_new');
        }
        $csr = openssl_csr_new($dn, $privkey, $config);
        if ($csr === false) {
            $this->printOpenSSLError('openssl_csr_new');
        }
        $cacert = 'file://'.$ca_file;
        $ca_privkey = array('file://'.$ca_key_file, csSettings::get('ca_cert_key_pass'));
        $sscert = openssl_csr_sign($csr, $cacert, $ca_privkey, $numberofdays, $config);
        if ($sscert === false) {
            $this->printOpenSSLError('openssl_csr_sign');
        }

        $base_file_path = $cert_dir.DIRECTORY_SEPARATOR.$cert_name;
        
        // save files to disk
        openssl_x509_export_to_file($sscert, $base_file_path.'.crt');
        openssl_pkey_export_to_file($privkey, $base_file_path.'.key', $privkeypass, $config);
        openssl_csr_export_to_file($csr, $base_file_path.'.csr');

        return true;
    }
    protected function printOpenSSLError($function_name) {
        $messages = array();
        while ($msg = openssl_error_string()) {
            $messages[] = $msg;
        }
        throw new sfException("An OpenSSL error occured in '".$function_name."'. Stacktrace: ".join("\n", $messages));
    }
}