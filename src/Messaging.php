<?php

namespace Unipile;

class Messaging extends UnipileSDK
{

    public function sendMessage($chatId, $text, $attachmentData)
    {
        try {
            $requestData = [
                'headers' => [
                    'X-API-KEY' => $this->token,
                    'Accept' => 'application/json',
                ],
            ];
    
            if (empty($attachmentData)) {
                $requestData['form_params'] = [
                    'text' => $text,
                ];
            } else {
                $requestData['multipart'] = [
                    [
                        'name' => 'text',
                        'contents' => $text,
                    ],
                    [
                        'name' => 'attachments',
                        'contents' => fopen($attachmentData['tmp_name'][0], 'r'),
                        'filename' => $attachmentData['name'][0],
                    ],
                ];
            }
    
            $response = $this->httpClient->post("/api/v1/chats/$chatId/messages", $requestData);
    
            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("Send Message in Chat Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }
    
    
    public function getAttachments($messageId, $attachmentId)
    {
        try {
            $response = $this->httpClient->get("/api/v1/messages/$messageId/attachments/$attachmentId", [
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return $response;
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("Get Attachments Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function listChatMessages($chatId, $queryParams = [])
    {
        try {
            $response = $this->httpClient->get("/api/v1/chats/$chatId/messages", [
                'query' => $queryParams,
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("List Chat Messages Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function listChats($queryParams = [])
    {
        try {
            $response = $this->httpClient->get("/api/v1/chats", [
                'query' => $queryParams,
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("List All Chats Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function listMessages($queryParams = [])
    {
        try {
            $response = $this->httpClient->get('/api/v1/messages', [
                'query' => $queryParams,
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("List Messages Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function getChat($chatId)
    {
        try {
            $response = $this->httpClient->get("/api/v1/chats/$chatId", [
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



    public function getAttendee($chatId)
    {
        try {
            $response = $this->httpClient->get("/api/v1/chat-attendees/$chatId", [

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


    public function getChatsAttendees()
    {
        try {
            $response = $this->httpClient->get("/api/v1/chat-attendees", [
                'json' => [
                    "limit" => 10000,
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

    public function getChatAttendees($chatId)
    {
        try {
            $response = $this->httpClient->get("/api/v1/chats/$chatId/attendees", [
                'json' => [
                    "chat_id" => $chatId,
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


    public function getMessage($messageId)
    {
        try {
            $response = $this->httpClient->get("/api/v1/messages/$messageId", [
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("Get Message Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    public function getMessages($messageId)
    {
        try {
            $response = $this->httpClient->get("/api/v1/messages", [
                'headers' => [
                    'X-API-KEY' => $this->token,
                ],
            ]);

            $this->handleAPIError($response);

            return json_decode($response->getBody(), true);
        } catch (UnipileSDKException $e) {
            throw new UnipileSDKException("Get Message Error: {$e->getMessage()}", $e->getCode(), $e);
        }
    }
}
