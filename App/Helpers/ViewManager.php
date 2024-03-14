<?php

namespace App\Helpers;


class ViewManager{

    public static function renderView(string $path, array $params = null)
    {
        ob_start();
        if (!is_null($params)) extract($params);
        $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
        require VIEWS . $path . '.php';
        $content = ob_get_clean();
        ob_start();
        require VIEWS . 'layout.php';
        return ob_get_clean();
    }

    public static function ViewError($errorMessage)
    {
        $body= ViewManager::renderView('errors.ErrorPage', compact('errorMessage'));
        return $body;
    }

}