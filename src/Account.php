<?php

namespace Unipile;

class Account extends UnipileSDK
{
    public function list()
    {
        $response = $this->httpClient->get('/api/v1/accounts', [
            'headers' => [
                'X-API-KEY' => $this->token,
            ],
        ]);
        $this->handleAPIError($response);

        return json_decode($response->getBody(), true);
    }

    public function delete($accountId)
    {
        try {
            $response = $this->httpClient->delete("/api/v1/accounts/$accountId", [
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);
    
            $this->handleAPIError($response);
    
            return true; // La suppression a réussi
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("Delete Account Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function connectToImap($email, $password, $imapHost, $imapPort, $smtpHost, $smtpPort)
    {
        try {
            $response = $this->httpClient->post('/api/v1/accounts', [
                'json' => [
                    'type' => 'MAIL',
                    'provider' => 'MAIL',
                    'email' => $email,
                    'password' => $password,
                    'connection_params' => [
                        'imap_host' => $imapHost,
                        'imap_port' => $imapPort,
                        'smtp_host' => $smtpHost,
                        'smtp_port' => $smtpPort,
                    ],
                ],
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $e) {
            echo "IMAP Connection Error: {$e->getMessage()}" . $e->getCode();
        } catch (GuzzleHttp\Exception\ServerException $e) {
            echo "IMAP Connection Error: {$e->getMessage()}" . $e->getCode();
        }
    }

    public function connectToLinkedin($username, $password)
    {
        try {
            $response = $this->httpClient->post('/api/v1/accounts', [
                'json' => [
                    'provider' => 'LINKEDIN',
                    'username' => $username,
                    'password' => $password,
                ],
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $e) {
            echo "IMAP Connection Error: {$e->getMessage()}" . $e->getCode();
        } catch (GuzzleHttp\Exception\ServerException $e) {
            echo "IMAP Connection Error: {$e->getMessage()}" . $e->getCode();
        }
    }

    public function connectToLinkedinCookie($access_token, $csrf_token)
    {
        try {
            $response = $this->httpClient->post('/api/v1/accounts', [
                'json' => [
                    'provider' => 'LINKEDIN',
                    'access_token' => $access_token,
                    'csrf_token' => $csrf_token,
                ],
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return $response->getBody()->getContents();
        } catch (GuzzleHttp\Exception\ClientException $e) {
            echo "IMAP Connection Error: {$e->getMessage()}" . $e->getCode();
        } catch (GuzzleHttp\Exception\ServerException $e) {
            echo "IMAP Connection Error: {$e->getMessage()}" . $e->getCode();
        }
    }

    public function connectToWhatsApp()
    {
        try {
            $response = $this->httpClient->post('/api/v1/accounts', [
                'json' => [
                    'provider' => 'WHATSAPP',
                    'callback_url' => 'test'
                ],
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("WhatsApp Connection Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function reconnectToWhatsApp($accountId)
    {
        try {
            $response = $this->httpClient->post("/api/v1/accounts/$accountId", [
                'json' => [
                    'provider' => 'WHATSAPP',
                ],
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("WhatsApp Connection Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function createHostedLink()
    {
        $timestamp = new \DateTime();
        $timestamp->add(new \DateInterval('PT1H'));

        try {
            $response = $this->httpClient->post("/api/v1/hosted/accounts/auth_link", [
                'json' => [
                    'providers' => '*',
                    'expiresOn' => $timestamp->format('Y-m-d\TH:i:s.000\Z')
                ],
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function generateWhatsAppQRCode($whatsappString)
    {
        $qrCode = new QrCode($whatsappString);
        header('Content-Type: ' . $qrCode->getContentType());
        echo $qrCode->writeString();
    }
}
