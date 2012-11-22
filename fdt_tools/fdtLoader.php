<?php

class fdtLoader {

    private $localDirName;
    private $localDirPath;
    private $documentRoot;
    private $isAdmin;

    public function __construct($isAdmin = false, $enviorment = 'prod', $localDirName = 'local')
    {
        $this->isAdmin = $isAdmin;
        $this->localDirName = $localDirName;
        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];

        switch ($enviorment)
        {
            case 'prod':
                $this->initProd();
            break;

            default:
                $this->initProd();
            break;

        }
    }

    private function getLocalDirName()
    {
        return $this->localDirName;
    }

    private function getDocumentRoot($hasSlash = false)
    {
        if ($hasSlash)
        {
            return $this->documentRoot.DIRECTORY_SEPARATOR;
        }
        return $this->documentRoot;
    }

    private function getLocalDirPath ()
    {
        return $this->getDocumentRoot()  . DIRECTORY_SEPARATOR . $this->getLocalDirName() . DIRECTORY_SEPARATOR;
    }

    private function hasLocalDir ()
    {
        $localDirPath = $this->getLocalDirPath();
        return file_exists($localDirPath);
    }

    public function getDirPath()
    {


        if ($this->hasLocalDir())
        {
            return $this->getLocalDirPath();

        }

        return $this->getDocumentRoot(true);

    }

    private function setGlobalsDir ($type = 'main')
    {
        $string = '';
        $path = $this->getDocumentRoot(true);

        if ($type == 'local')
        {

            $path = $this->getLocalDirPath ();
            $string = '_LOCAL';

        }

        if ($this->isAdmin)
        {
            define('DIR'.$string.'_APPLICATION', $path.'admin/');
            define('DIR'.$string.'_TEMPLATE', $path.'admin/view/template/');
            define('DIR'.$string.'_LANGUAGE', $path.'admin/language/');

        }
        else
        {
            define('DIR'.$string.'_APPLICATION', $path.'catalog/');
            define('DIR'.$string.'_TEMPLATE', $path.'catalog/view/theme/');
            define('DIR'.$string.'_LANGUAGE', $path.'catalog/language/');
        }



        define('DIR'.$string.'_SYSTEM', $path.'system/');
        define('DIR'.$string.'_DATABASE', $path.'system/database/');
        define('DIR'.$string.'_CONFIG', $path.'system/config/');
        define('DIR'.$string.'_IMAGE', $path.'image/');
        define('DIR'.$string.'_CACHE', $path.'system/cache/');
        define('DIR'.$string.'_DOWNLOAD', $path.'download/');
        define('DIR'.$string.'_LOGS', $path.'system/logs/');
        define('DIR'.$string.'_CATALOG', $path.'/catalog/');


    }

    private function includeConfiguration ()
    {
        $localDirPath = $this->getLocalDirPath();
        $documentRoot = $this->getDocumentRoot(true);

        if ($this->isAdmin)
        {
            $localDirPath = $localDirPath.'admin/';
            $documentRoot = $documentRoot.'admin/';
        }

       // Configuration
        if (file_exists($localDirPath . 'config.php'))
        {
            require_once($localDirPath . 'config.php');
        }
        else
        {
            require_once($documentRoot .'config.php');
        }
    }

    private function initProd()
    {
        $this->includeConfiguration ();

        $this->setGlobalsDir ();
        $this->setGlobalsDir ('local');


        $this->includeClasses ();

    }

    private function getLibDir ($type = 'local', $toBeReturned)
    {
        $path = $this->getDocumentRoot(true);
        if ($type == 'local')
        {
            $path = $this->getLocalDirPath();
        }

        // DIR OVERWRITTEN
        $this->arrayDirectories = array (

            'application'=>$path.'catalog/',
            'system'=>$path.'system/',
            'database'=>$path.'system/database/',
            'language'=>$path.'catalog/language/',
            'template'=>$path.'catalog/view/theme/',
            'config'=>$path.'system/config/'
            );

        return ($this->arrayDirectories[$toBeReturned]);

    }

    public function getSystemClass ($type = 'local')
    {
        $arraySystemClasses = array (
                'local' => $this->getLibDir('local', 'system'),
                'main' => $this->getLibDir('main', 'system')
        );

        return ($arraySystemClasses[$type]);
    }

    private function includeClasses ()
    {
        // Startup
        $localSystemDir = $this->getSystemClass('local');
        $mainSystemDir = $this->getSystemClass('main');


        if (file_exists($localSystemDir . 'startup.php'))
        {
            require_once($localSystemDir . 'startup.php');
        }
        else
        {
            require_once($this->getLibDir('main', 'system') . 'startup.php');
        }

        // Application Classes
        if (file_exists($localSystemDir . 'library/customer.php'))
        {
            require_once($localSystemDir . 'library/customer.php');
        }
        else
        {
            require_once($this->getLibDir('main', 'system') . 'library/customer.php');
        }

        if (file_exists($localSystemDir . 'library/affiliate.php'))
        {
            require_once($localSystemDir . 'library/affiliate.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/affiliate.php');
        }

        if (file_exists($localSystemDir . 'library/currency.php'))
        {
            require_once($localSystemDir . 'library/currency.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/currency.php');
        }

        if (file_exists($localSystemDir . 'library/tax.php'))
        {
            require_once($localSystemDir . 'library/tax.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/tax.php');
        }

        if (file_exists($localSystemDir . 'library/weight.php'))
        {
            require_once($localSystemDir . 'library/weight.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/weight.php');
        }

        if (file_exists($localSystemDir . 'library/length.php'))
        {
            require_once($localSystemDir . 'library/length.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/length.php');
        }

        if (file_exists($localSystemDir . 'library/cart.php'))
        {
            require_once($localSystemDir . 'library/cart.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/cart.php');
        }

        if (file_exists($localSystemDir . 'library/user.php'))
        {
            require_once($localSystemDir . 'library/user.php');

        }
        else
        {
            require_once($mainSystemDir . 'library/user.php');
        }


        // Helper
        if (file_exists($localSystemDir . 'helper/json.php'))
        {
            require_once($localSystemDir . 'helper/json.php');
        }
        else
        {
            require_once($mainSystemDir . 'helper/json.php');
        }

        if (file_exists($localSystemDir . 'helper/utf8.php'))
        {
            require_once($localSystemDir . 'helper/utf8.php');
        }
        else
        {
            require_once($mainSystemDir . 'helper/utf8.php');
        }

        // Engine
        if (file_exists($localSystemDir . 'engine/action.php'))
        {
            require_once($localSystemDir . 'engine/action.php');
        }
        else
        {
            require_once($mainSystemDir . 'engine/action.php');
        }

        if (file_exists($localSystemDir . 'engine/controller.php'))
        {
            require_once($localSystemDir . 'engine/controller.php');
        }
        else
        {
            require_once($mainSystemDir . 'engine/controller.php');
        }

        if (file_exists($localSystemDir . 'engine/front.php'))
        {
            require_once($localSystemDir . 'engine/front.php');
        }
        else
        {
            require_once($mainSystemDir . 'engine/front.php');
        }

        if (file_exists($localSystemDir . 'engine/loader.php'))
        {
            require_once($localSystemDir . 'engine/loader.php');
        }
        else
        {
            require_once($mainSystemDir . 'engine/loader.php');
        }

        if (file_exists($localSystemDir . 'engine/model.php'))
        {
            require_once($localSystemDir . 'engine/model.php');
        }
        else
        {
            require_once($mainSystemDir . 'engine/model.php');
        }

        if (file_exists($localSystemDir . 'engine/registry.php'))
        {
            require_once($localSystemDir . 'engine/registry.php');
        }
        else
        {
            require_once($mainSystemDir . 'engine/registry.php');
        }

        // Common
        if (file_exists($localSystemDir . 'library/cache.php'))
        {
            require_once($localSystemDir . 'library/cache.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/cache.php');
        }

        if (file_exists($localSystemDir . 'library/url.php'))
        {
            require_once($localSystemDir . 'library/url.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/url.php');
        }

        if (file_exists($localSystemDir . 'library/config.php'))
        {
            require_once($localSystemDir . 'library/config.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/config.php');
        }

        if (file_exists($localSystemDir . 'library/db.php'))
        {
            require_once($localSystemDir . 'library/db.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/db.php');
        }

        if (file_exists($localSystemDir . 'library/document.php'))
        {
            require_once($localSystemDir . 'library/document.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/document.php');
        }

        if (file_exists($localSystemDir . 'library/encryption.php'))
        {
            require_once($localSystemDir . 'library/encryption.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/encryption.php');
        }

        if (file_exists($localSystemDir . 'library/image.php'))
        {
            require_once($localSystemDir . 'library/image.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/image.php');
        }

        if (file_exists($localSystemDir . 'library/language.php'))
        {
            require_once($localSystemDir . 'library/language.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/language.php');
        }

        if (file_exists($localSystemDir . 'library/log.php'))
        {
            require_once($localSystemDir . 'library/log.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/log.php');
        }

        if (file_exists($localSystemDir . 'library/mail.php'))
        {
            require_once($localSystemDir . 'library/mail.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/mail.php');
        }

        if (file_exists($localSystemDir . 'library/pagination.php'))
        {
            require_once($localSystemDir . 'library/pagination.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/pagination.php');
        }

        if (file_exists($localSystemDir . 'library/request.php'))
        {
            require_once($localSystemDir . 'library/request.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/request.php');
        }

        if (file_exists($localSystemDir . 'library/response.php'))
        {
            require_once($localSystemDir . 'library/response.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/response.php');
        }

        if (file_exists($localSystemDir . 'library/session.php'))
        {
            require_once($localSystemDir . 'library/session.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/session.php');
        }

        if (file_exists($localSystemDir . 'library/template.php'))
        {
            require_once($localSystemDir . 'library/template.php');
        }
        else
        {
            require_once($mainSystemDir . 'library/template.php');
        }
    }











}