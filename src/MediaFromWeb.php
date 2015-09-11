<?php
namespace Elozoya\MediaFromWeb;

class MediaFromWeb
{
    private $httpClient;
    private $supportedContentTypes = ["image/png", "image/jpeg"];

    public function __construct(\GuzzleHttp\Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getPhotosFromUrl($url)
    {
        $photos = [];
        if (!$this->isURLValid($url)) {
            return (object)[
                "error" => true,
                'message' => "Invalid URL format",
            ];
        }
        $response = $this->httpClient->request('HEAD', $url);
        if (!$response->isSuccessful()) {
            return (object)[
                "error" => true,
                'message' => "Photos not found or you are not allowed to get them",
            ];
        }
        if (!in_array($response->getHeader('content-type'), $this->supportedContentTypes)) {
            return (object)[
                "error" => true,
                'message' => "Photos not found due to an unsupported request",
            ];
        }
        $photos[] = (object)["photo_src" => $url];
        $result = (object)[
          "data" => $photos,
        ];
        return $result;
    }

    private function isURLValid($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
