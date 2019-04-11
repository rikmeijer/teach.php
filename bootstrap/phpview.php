<?php use pulledbits\View\TemplateInstance;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {
    $session = $bootstrap->resource('session');
    $basedir = $bootstrap->config('PHPVIEW')['path'];

    $directory = new \pulledbits\View\Directory(
        $basedir . DIRECTORY_SEPARATOR . 'views',
        $basedir . DIRECTORY_SEPARATOR . 'layouts'
    );

    $directory->registerHelper(
        'url',
        function (\pulledbits\View\TemplateInstance $templateInstance, string $path, string ...$unencoded): string {
            $encoded = array_map('rawurlencode', $unencoded);
            if (strpos($path, '.') === 0) {
                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '/' . $path;
            }

            $path = str_replace('\\', '/', $path);
            $parts = array_filter(explode('/', $path), 'strlen');
            $absolutes = array();
            foreach ($parts as $part) {
                if ('.' === $part) {
                    continue;
                }
                if ('..' === $part) {
                    array_pop($absolutes);
                } else {
                    $absolutes[] = $part;
                }
            }

            $path = sprintf(implode('/', $absolutes), ...$encoded);
            if (strpos($path, '?') === false) {
                $query = '';
            } else {
                list($path, $query) = explode('?', $path, 2);
            }
            return (string)\GuzzleHttp\Psr7\ServerRequest::getUriFromGlobals()->withPath($path)->withQuery($query);
        }
    );

    $directory->registerHelper(
        'form',
        function (\pulledbits\View\TemplateInstance $templateInstance, string $method, string $submitValue, string $model) use ($session) : void {
            ?>
            <form method="<?= $templateInstance->escape($method); ?>">
                <input type="hidden" name="__csrf_value"
                       value="<?= $templateInstance->escape($session->getCsrfToken()->getValue()); ?>"/>
                <?= $model; ?>
                <input type="submit" value="<?= $templateInstance->escape($submitValue); ?>"/>
            </form>
            <?php
        }
    );

    $directory->registerHelper('rating', function(TemplateInstance $templateInstance, int $rating, int $width, int $height) {
        if ($rating === 0) {
            ?><div style="display: inline-block; width: <?=$templateInstance->escape($width)?>px; height: <?=$templateInstance->escape($height)?>px; background-size: contain;background-image: url(/img/nostar.png); background-repeat: repeat-x;"></div><?php
        } else {
            ?><div style="display: inline-block; width: <?=$templateInstance->escape($width)?>px; height: <?=$templateInstance->escape($height)?>px; background-size: contain;background-image: url(/img/unstar.png); background-repeat: repeat-x;"><div style="width: <?=$templateInstance->escape($rating/5*$width)?>px; height: <?=$templateInstance->escape($height)?>px; background-size: contain;background-image: url(/img/star.png); background-repeat: repeat-x;"></div></div><?php
        }
    });



    $directory->registerHelper('resource', function (\pulledbits\View\TemplateInstance $templateInstance, string $resourceIdentfier) use ($bootstrap) : object {
        return $bootstrap->resource($resourceIdentfier);
    });
    return $directory;
};
