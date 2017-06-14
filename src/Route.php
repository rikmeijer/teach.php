<?php
/**
 * User: hameijer
 * Date: 7-6-17
 * Time: 10:12
 */

namespace rikmeijer\Teach;


interface Route
{

    public function __invoke(\Psr\Http\Message\RequestInterface $request, \rikmeijer\Teach\Resources $resources) : \Psr\Http\Message\ResponseInterface;

}