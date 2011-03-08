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

        $cert = new OpenSSLCertificate($arguments['cert_name']);

        if (!$cert->exists()) {
            $this->log("Generating new certificate.");
            return $cert->generateNew();
        } else {
            $this->log("Certificate already exists, skipping.");
        }

    }
}
