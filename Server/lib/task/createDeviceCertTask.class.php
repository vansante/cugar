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

        $this->logSection('openssl', "Generating keys for certificate name '".$arguments['cert_name']."'");

        $cert_dir = csSettings::get('certificate_dir');

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
        $ca_cert = file_get_contents($ca_file);

        $privkey = openssl_pkey_new($config);
        if ($privkey === false) {
            $this->printOpenSSLErrors('openssl_pkey_new');
        }
        $csr = openssl_csr_new($dn, $privkey, $config);
        if ($csr === false) {
            $this->printOpenSSLErrors('openssl_csr_new');
        }
        $sscert = openssl_csr_sign($csr, $ca_cert, $privkey, $numberofdays, $config);
        if ($sscert === false) {
            $this->printOpenSSLErrors('openssl_csr_sign');
        }
        openssl_x509_export($sscert, $publickey);
        openssl_pkey_export($privkey, $privatekey, $privkeypass, $config);
        openssl_csr_export($csr, $csrStr);

        echo $privatekey; // Will hold the exported PriKey
        echo $publickey;  // Will hold the exported PubKey
        echo $csrStr;     // Will hold the exported Certificate


        return true;
    }
    protected function printOpenSSLErrors($function_name) {
        while ($msg = openssl_error_string()) {
            $this->logSection('Error', "OpenSSL: ". $msg);
        }
        throw new sfException("An OpenSSL error occured in '".$function_name."'");
    }
}
