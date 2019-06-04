<?php

namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;
use pulledbits\View\TemplateInstance;

class PHPviewEndPoint implements RouteEndPoint
{
    /**
     * @var \pulledbits\View\TemplateInstance
     */
    private $phpview;

    public function __construct(\pulledbits\View\Template $phpview)
    {
        $this->phpview = $phpview->prepare();
    }

    public static function attachToResponse(ResponseInterface $response, TemplateInstance $templateInstance) : ResponseInterface {
        $reader = function(int $length) use ($templateInstance) : ?string {
            static $buffer;
            if (isset($buffer) === false) {
                try {
                    $buffer = $templateInstance->capture();
                } catch (\Error $e) {
                    error_log($e->getMessage() . ':' . $e->getTraceAsString());
                }
            } elseif ($buffer === false) {
                return null;
            }

            if ($length < strlen($buffer)) {
                $read = $buffer;
                $buffer = false;
            } elseif ($length === strlen($buffer)) {
                $read = $buffer;
                $buffer = false;
            } else {
                $read = substr($buffer, 0, $length);
                $buffer = substr($buffer, $length);
            }

            return $read;
        };
        return $response->withBody(\GuzzleHttp\Psr7\stream_for($reader))->withHeader('Etag', '"' . $templateInstance->serial() . '"');
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return self::attachToResponse($psrResponse, $this->phpview);
    }
}
