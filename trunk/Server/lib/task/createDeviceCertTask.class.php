<?php

class createDeviceCertTask extends sfBaseTask {

    protected function configure() {
        // // add your own arguments here
        $this->addArguments(array(
            new sfCommandArgument('cert_name', sfCommandArgument::REQUIRED, 'Name of the certificate'),
        ));

        $this->addOptions(array(
//            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
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

        // Code borrowed from: http://www.php.net/manual/en/function.openssl-pkey-new.php
        $dn = array(
            "countryName" => csSettings::get('cert_key_country_code'),
            "stateOrProvinceName" => csSettings::get('cert_key_province_code'),
            "localityName" => csSettings::get('cert_key_city'),
            "organizationName" => csSettings::get('cert_key_organisation'),
            "organizationalUnitName" => '',
            "commonName" => '',
            "emailAddress" => csSettings::get('cert_key_email')
        );
        $privkeypass = csSettings::get('cert_pass_key');
        $numberofdays = csSettings::get('cert_crt_expire_days');

        $ca_cert = file_get_contents($cert_dir.DIRECTORY_SEPARATOR.'ca.crt');

        $privkey = openssl_pkey_new();
        $csr = openssl_csr_new($dn, $privkey);
        $sscert = openssl_csr_sign($csr, $ca_cert, $privkey, $numberofdays);
        openssl_x509_export($sscert, $publickey);
        openssl_pkey_export($privkey, $privatekey, $privkeypass);
        openssl_csr_export($csr, $csrStr);

        echo $privatekey; // Will hold the exported PriKey
        echo $publickey;  // Will hold the exported PubKey
        echo $csrStr;     // Will hold the exported Certificate
    }

}
