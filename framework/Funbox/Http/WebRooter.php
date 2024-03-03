<?php

namespace Funbox\Framework\Http;

use Phink\MVC\TView;
use Phink\Registry\TRegistry;
use Phink\TAutoloader;

class WebRooter extends AbstractRouter
{
    public function translate(): bool
    {
        $isTranslated = false;

        $info = (object) \pathinfo($this->path);
        $this->viewName = $info->filename;
        $this->dirName = $info->dirname;
        $this->bootDirName = $info->dirname;

        if ($this->componentIsInternal) {
            $this->dirName = dirname($this->dirName, 2);
        }

        $this->className = ucfirst($this->viewName);

        $this->setNamespace();
        $this->setNames();

        if (file_exists(SRC_ROOT . $this->getPath())) {
            // $this->path = SRC_ROOT . $this->getPath();
            $isTranslated = true;
        }

        if (file_exists(SITE_ROOT . $this->getPath())) {
            // $this->path = SITE_ROOT . $this->getPath();
            $isTranslated = true;
        }

        $this->_isCached = file_exists($this->getCacheFileName());

        return $this->_isCached || $isTranslated;
    }

    public function dispatch(): bool
    {

        $dir = WebRooter . phpdirname(SRC_ROOT . $this->bootDirName, 1) . DIRECTORY_SEPARATOR;

        if ($this->componentIsInternal) {
            $dir = WebRooter . phpdirname(SITE_ROOT . $this->bootDirName, 1) . DIRECTORY_SEPARATOR;
        }

        if (file_exists($dir . 'bootstrap' . CLASS_EXTENSION)) {
            list($namespace, $className, $classText) = TAutoloader::getClassDefinition($dir . 'bootstrap' . CLASS_EXTENSION);
            include $dir . 'bootstrap' . CLASS_EXTENSION;

            $bootstrapClass = $namespace . '\\'  . $className;

            $bootstrap = new $bootstrapClass($dir);
            $bootstrap->start();
        }

        $view = new TView($this);

        if ($this->_isCached) {
            $class = TAutoloader::loadCachedFile($view);
            $class->perform();
            return true;
        }

        list($file, $class, $classText) = $this->includeController($view);
        $namespace = TAutoloader::grabKeywordName('namespace', $classText, ';');
        $className = TAutoloader::grabKeywordName('class', $classText, ' ');

        $view->parse();
        $uid = $view->getUID();
        $code = TRegistry::getCode($uid);

        // file_put_contents($this->getCacheFileName(), $code);

        eval('?>' . $code);

        $fqClassName = $namespace . '\\' . $className;

        $controller = new $fqClassName($view);

        $controller->perform();

        if ($view->isReedEngine()) {
            // cache the file
            $php = TRegistry::getHtml($uid);
            $code = str_replace(HTML_PLACEHOLDER, $php, $code);
            file_put_contents($this->getCacheFileName(), $code);
        }
        return false;
    }
}
