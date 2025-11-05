<?php

namespace app\components;

use Aws\S3\S3Client;
use yii\base\Component;
use Yii;

/**
 * S3 Service Component
 * 
 * Handles file uploads to AWS S3 (or LocalStack for local development)
 * Clean code: Encapsulates S3 logic in a reusable component
 */
class S3Service extends Component
{
    public $endpoint;
    public $region;
    public $credentials;

    private $_client;

    /**
     * Initialize S3 client
     */
    public function init()
    {
        parent::init();
        
        $config = [
            'version' => 'latest',
            'region' => $this->region,
            'credentials' => $this->credentials,
        ];

        // Add endpoint for LocalStack
        if ($this->endpoint) {
            $config['endpoint'] = $this->endpoint;
            $config['use_path_style_endpoint'] = true;
        }

        $this->_client = new S3Client($config);
    }

    /**
     * Upload file to S3
     * 
     * KISS: Simple upload method with clear parameters
     * 
     * @param string $bucket
     * @param string $key
     * @param mixed $body
     * @param array $options
     * @return array
     */
    public function upload($bucket, $key, $body, $options = [])
    {
        try {
            $result = $this->_client->putObject(array_merge([
                'Bucket' => $bucket,
                'Key' => $key,
                'Body' => $body,
            ], $options));

            return [
                'success' => true,
                'url' => $result['ObjectURL'] ?? null,
                'key' => $key,
            ];
        } catch (\Exception $e) {
            Yii::error("S3 upload failed: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Download file from S3
     * 
     * @param string $bucket
     * @param string $key
     * @return array
     */
    public function download($bucket, $key)
    {
        try {
            $result = $this->_client->getObject([
                'Bucket' => $bucket,
                'Key' => $key,
            ]);

            return [
                'success' => true,
                'body' => $result['Body'],
            ];
        } catch (\Exception $e) {
            Yii::error("S3 download failed: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete file from S3
     * 
     * @param string $bucket
     * @param string $key
     * @return array
     */
    public function delete($bucket, $key)
    {
        try {
            $this->_client->deleteObject([
                'Bucket' => $bucket,
                'Key' => $key,
            ]);

            return ['success' => true];
        } catch (\Exception $e) {
            Yii::error("S3 delete failed: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get presigned URL for file
     * 
     * @param string $bucket
     * @param string $key
     * @param string $expiration (e.g., '+20 minutes')
     * @return string|null
     */
    public function getPresignedUrl($bucket, $key, $expiration = '+20 minutes')
    {
        try {
            $cmd = $this->_client->getCommand('GetObject', [
                'Bucket' => $bucket,
                'Key' => $key,
            ]);

            $request = $this->_client->createPresignedRequest($cmd, $expiration);
            return (string) $request->getUri();
        } catch (\Exception $e) {
            Yii::error("S3 presigned URL failed: " . $e->getMessage());
            return null;
        }
    }
}
