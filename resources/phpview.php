<?php return function (\rikmeijer\Teach\Bootstrap $bootstrap) {
    $session = $bootstrap->resource('session');
    $basedir = $bootstrap->config('PHPVIEW')['path'];

    $directory = new \pulledbits\View\Directory(
        $basedir . DIRECTORY_SEPARATOR . 'views',
        $basedir . DIRECTORY_SEPARATOR . 'layouts'
    );

    function get_absolute_path($path)
    {
        $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
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
        return implode(DIRECTORY_SEPARATOR, $absolutes);
    }

    $directory->registerHelper(
        'url',
        function (string $path, string ...$unencoded): string {
            $encoded = array_map('rawurlencode', $unencoded);
            if (strpos($path, '.') === 0) {
                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '/' . $path;
            }

            $path = sprintf(get_absolute_path($path), ...$encoded);
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
        function (string $method, string $submitValue, string $model) use ($session) : void {
            ?>
            <form method="<?= $this->escape($method); ?>">
                <input type="hidden" name="__csrf_value"
                       value="<?= $this->escape($session->getCsrfToken()->getValue()); ?>"/>
                <?= $model; ?>
                <input type="submit" value="<?= $this->escape($submitValue); ?>"/>
            </form>
            <?php
        }
    );
    return $directory;
};
