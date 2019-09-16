<?php

namespace backend\components;

use GuzzleHttp\Client;
use yii\helpers\Json;

class RedmineClient
{
    /**
     * {@inheritdoc}
     */
    public $authUrl = 'http://oauth.handh.ru:9888/oauth?';

    public $apiUrl = 'http://oauth.handh.ru:9888/oauth';

    /**
     * {@inheritdoc}
     */
    public function getUrl(array $params = [])
    {
        $defaultParams = [
            'redirect_uri' => '/admin/site/redmine-auth',
            'client_id' => 9,
        ];
        return $this->authUrl . http_build_query($defaultParams);
    }

    public function getProfile($token)
    {
        $client = new Client();
        $response = $client->request('GET', $this->apiUrl . '/token?token=' . $token, [
            'headers' => ['Content-Type' => 'application/json'],
        ]);
        return Json::decode($response->getBody()->getContents(), true);
    }

    public function initUserAttributes()
    {
        // TODO: Implement initUserAttributes() method.
    }
}