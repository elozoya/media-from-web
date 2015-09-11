<?php
namespace Elozoya\MediaFromWeb;

class MediaFromWeb
{
    private $httpClient;

    public function __construct(\GuzzleHttp\Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getPhotosFromUrl($url)
    {
        $photos = [];
        $result = (object)[
          "data" => $photos,
        ];
        $response = $this->httpClient->request('HEAD', $url);
        if (!$response->isSuccessful()) {
            return (object)[
                "error" => true,
                'message' => "Photos not found or you are not allowed to get them",
            ];
        }
        return $result;
    }
}
