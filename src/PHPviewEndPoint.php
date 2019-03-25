<?php

namespace rikmeijer\Teach;

use Psr\Http\Message\ResponseInterface;
use pulledbits\Router\RouteEndPoint;

class PHPviewEndPoint implements RouteEndPoint
{
    /**
     * @var \pulledbits\View\TemplateInstance
     */
    private $phpview;
    private $buffer;

    public function __construct(\pulledbits\View\Template $phpview)
    {
        $this->phpview = $phpview->prepare();
    }

    public function respond(ResponseInterface $psrResponse): ResponseInterface
    {
        return $psrResponse->withBody(\GuzzleHttp\Psr7\stream_for([$this, 'read']));
    }

    public function read(int $length) : ?string {
        if (isset($this->buffer) === false) {
            $this->buffer = $this->phpview->capture();
        } elseif ($this->buffer === false) {
            return null;
        }

        if ($length < strlen($this->buffer)) {
            $read = $this->buffer;
            $this->buffer = false;
        } elseif ($length === strlen($this->buffer)) {
            $read = $this->buffer;
            $this->buffer = false;
        } else {
            $read = substr($this->buffer, 0, $length);
            $this->buffer = substr($this->buffer, $length);
        }

        return $read;
    }
}
