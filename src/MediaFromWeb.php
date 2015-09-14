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
        $statusCode = $response->getStatusCode();
        if (!($statusCode >= 200 && $statusCode < 300)) {
            return (object)[
                "error" => true,
                'message' => "Photos not found or you are not allowed to get them",
            ];
        }
        if (!$this->isContentTypeSupported($response->getHeader('content-type'))) {
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

    private function isContentTypeSupported($contentTypeHeader)
    {
        if (is_array($contentTypeHeader)) {
            foreach ($this->supportedContentTypes as $supportedContentType) {
                if (strpos($contentTypeHeader[0], $supportedContentType) !== false) {
                    return true;
                }
            }
        }
        return in_array($contentTypeHeader, $this->supportedContentTypes);
    }
}
