<?php
namespace Teach\Adapters\HTTP;

final class Response {
    public function send($stream) {
        fwrite($stream, '');
    }
}