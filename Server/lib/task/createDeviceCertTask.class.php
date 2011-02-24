<?php

class createDeviceCertTask extends sfBaseTask {

    protected function configure() {
        // // add your own arguments here
        $this->addArguments(array(
            new sfCommandArgument('cert_name', sfCommandArgument::REQUIRED, 'Name of the certificate'),
        ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
//            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
                // add your own options here
        ));

        $this->namespace = 'cugar';
        $this->name = 'create-device-cert';
        $this->briefDescription = '';
        $this->detailedDescription = <<<EOF
The [createDeviceCert|INFO] task generates new certificates.
Call it with:

  [php symfony createDeviceCert cert_name cert_path]
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        $cert_name = $arguments['cert_name'];
        $cert_dir = csSettings::get('certificate_dir');

        $base_file_path = $cert_dir.DIRECTORY_SEPARATOR.$cert_name;

        $file_exist_count = 0;
        if (file_exists($base_file_path.'.crt')) {
            $file_exists++;
        }
        if (file_exists($base_file_path.'.key')) {
            $file_exists++;
        }

        if ($file_exist_count == 2) {
            $this->logSection("openssl", "Certificates already exist");
            return false;
        } else if ($file_exist_count == 1) {
            $this->logSection("openssl", "Certificates already exist");
        }

        $this->logSection("openssl", "Generating certificate '".$cert_name."'");

        $openssl_cnf = csSettings::get('openssl_cnf_path');
        if (!file_exists($openssl_cnf)) {
            throw new sfException("Couldn't find openssl.cnf at '".$openssl_cnf."'");
        }
        if (!is_readable($openssl_cnf)) {
            throw new sfException("Couldn't read openssl.cnf at '".$openssl_cnf."'");
        }
        
        // Code borrowed from: http://www.php.net/manual/en/function.openssl-pkey-new.php
        $dn = array(
            "countryName" => csSettings::get('cert_key_country_code'),
            "stateOrProvinceName" => csSettings::get('cert_key_province_code'),
            "localityName" => csSettings::get('cert_key_city'),
            "organizationName" => csSettings::get('cert_key_organisation'),
            "organizationalUnitName" => 'CUGAR',
            "commonName" => csSettings::get('cert_key_common_name'),
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
        $ca_key = file_get_contents($ca_key_file);

        $privkey = openssl_pkey_new($config);
        if ($privkey === false) {
            $this->printOpenSSLErrors('openssl_pkey_new');
        }
        $csr = openssl_csr_new($dn, $privkey, $config);
        if ($csr === false) {
            $this->printOpenSSLErrors('openssl_csr_new');
        }
        $sscert = openssl_csr_sign($csr, $ca_cert, $ca_key, $numberofdays, $config);
        if ($sscert === false) {
            $this->printOpenSSLErrors('openssl_csr_sign');
        }
        // save files to disk
        openssl_x509_export_to_file($sscert, $base_file_path.'.crt');
        openssl_pkey_export_to_file($privkey, $base_file_path.'.key', $privkeypass, $config);
        openssl_csr_export_to_file($csr, $base_file_path.'.csr');

        return true;
    }
    protected function printOpenSSLErrors($function_name) {
        while ($msg = openssl_error_string()) {
            $this->logSection("Error", "OpenSSL: ". $msg);
        }
        throw new sfException("An OpenSSL error occured in '".$function_name."'");
    }
}
