<?php

namespace Core;

class Controller
{
    public function loadView(string $viewName, array $viewData = []): void
    {
        extract($viewData);
        require 'Views/'.$viewName.'.php';
    }

    public function loadTemplate(string $viewName, array $viewData = []): void
    {
        require 'Views/template.php';
    }

    public function loadViewInTemplate(string $viewName, array $viewData = []): void
    {
        extract($viewData);
        require 'Views/'.$viewName.'.php';
    }

    public function loadLibrary(string $library): void
    {
        if (file_exists('vendor/'.$library.'.php')) {
            require 'vendor/'.$library.'.php';
        }
    }
}
