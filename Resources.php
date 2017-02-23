<?php
/**
 * Created by PhpStorm.
 * User: hameijer
 * Date: 22-2-17
 * Time: 9:25
 */
namespace rikmeijer\Teach;

interface Resources
{
    public function schema(): \pulledbits\ActiveRecord\SQL\Schema;

    public function session(): \Aura\Session\Session;

    public function router(): \Aura\Router\RouterContainer;

    public function phpview($templateIdentifier) : \pulledbits\View\Template;

    public function readAssetStar();

    public function readAssetUnstar();
}