<?php 

include 'error_log.php';

// Check if OpenSSL extension is loaded
if (!extension_loaded('openssl')) {
    die("OpenSSL extension is not loaded. Please install/enable it first.");
}

// Steps to generate SSL in PHP:
// 1. Generate private key
// 2. Create certificate signing request (CSR)
// 3. Generate self-signed certificate from CSR
// 4. Save certificate and private key to files
// 5. Test SSL connection

class SSLGenerator {

    private $privateKey;
    private $certificate;

    public function generatePrivateKey() {
        echo "Generating private key...\n";
        
        // Configuration for private key
        $config = [
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];
        
        // Generate private key
        $this->privateKey = openssl_pkey_new($config);
        
        if (!$this->privateKey) {
            throw new Exception("Failed to generate private key");
        }
        
        echo "Private key generated successfully\n";
        return $this->privateKey;
    }

    public function generateCertificate() {
        echo "Generating certificate...\n";
        
        if (!$this->privateKey) {
            throw new Exception("Private key not generated yet");
        }
        
        // Certificate details
        $dn = [
            "countryName" => "US",
            "stateOrProvinceName" => "California",
            "localityName" => "San Francisco",
            "organizationName" => "Test Company",
            "organizationalUnitName" => "IT Department",
            "commonName" => "localhost",
            "emailAddress" => "test@example.com"
        ];
        
        // Generate certificate
        $csr = openssl_csr_new($dn, $this->privateKey);
        if (!$csr) {
            throw new Exception("Failed to create CSR");
        }
        
        // Self-sign the certificate (valid for 365 days)
        $this->certificate = openssl_csr_sign($csr, null, $this->privateKey, 365);
        
        if (!$this->certificate) {
            throw new Exception("Failed to sign certificate");
        }
        
        echo "Certificate generated successfully\n";
        return $this->certificate;
    }

    public function saveCertificate($filename = "certificate.pem") {
        echo "Saving certificate to $filename...\n";
        
        if (!$this->certificate) {
            throw new Exception("Certificate not generated yet");
        }
        
        // Export certificate to file
        $result = openssl_x509_export_to_file($this->certificate, $filename);
        
        if (!$result) {
            throw new Exception("Failed to save certificate");
        }
        
        echo "Certificate saved successfully\n";
        return true;
    }

    public function savePrivateKey($filename = "private.key") {
        echo "Saving private key to $filename...\n";
        
        if (!$this->privateKey) {
            throw new Exception("Private key not generated yet");
        }
        
        // Export private key to file
        $result = openssl_pkey_export_to_file($this->privateKey, $filename);
        
        if (!$result) {
            throw new Exception("Failed to save private key");
        }
        
        echo "Private key saved successfully\n";
        return true;
    }

    public function generateSSL() {
        try {
            echo "Starting SSL generation process...\n";
            
            $this->generatePrivateKey();
            $this->generateCertificate();
            $this->saveCertificate();
            $this->savePrivateKey();
            
            echo "SSL generation completed successfully!\n";
            echo "Files created: certificate.pem, private.key\n";
            
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            return false;
        }
    }
    
    // Display certificate info
    public function displayCertificateInfo() {
        if ($this->certificate) {
            openssl_x509_export($this->certificate, $output);
            echo "Certificate details:\n";
            echo $output . "\n";
        }
    }
}

// Run the SSL generator
$sslGenerator = new SSLGenerator();
$sslGenerator->generateSSL();
$sslGenerator->displayCertificateInfo();

?>
