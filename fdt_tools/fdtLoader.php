<?php


class fdtLoader {

    private $localDirName;
    private $localDirPath;
    private $documentRoot;
    private $isAdmin;
    private $vqmod;

    public function __construct($isAdmin = false, $vqmod, $enviorment = 'prod', $localDirName = 'local')
    {
        $this->isAdmin = $isAdmin;
        $this->localDirName = $localDirName;
        $this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
        $this->vqmod = $vqmod;

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

    public function getVqmodObject()
    {
        return $this->vqmod;
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

    private function getAbsoluteClassPath ($relativeClassPath)
    {
        $localSystemDir = $this->getSystemClass('local');
        $mainSystemDir = $this->getSystemClass('main');


        if (file_exists($localSystemDir . $relativeClassPath))
        {
            return ($localSystemDir . $relativeClassPath);

        }
        else
        {
            return ($this->getLibDir('main', 'system') . $relativeClassPath);
        }
    }

    private function requireClass ($relativeClassPath)
    {
        $vqmod = $this->getVqmodObject ();

        $absoluteClassPath = $this->getAbsoluteClassPath ($relativeClassPath);

        require_once($vqmod->modCheck($absoluteClassPath));

    }


    private function includeClasses ()
    {
        // Startup
        $localSystemDir = $this->getSystemClass('local');
        $mainSystemDir = $this->getSystemClass('main');

        $this->requireClass ('startup.php');
        $this->requireClass ('library/customer.php');
        $this->requireClass ('library/affiliate.php');
        $this->requireClass ('library/currency.php');
        $this->requireClass ('library/tax.php');
        $this->requireClass ('library/weight.php');
        $this->requireClass ('library/length.php');
        $this->requireClass ('library/cart.php');
        $this->requireClass ('library/user.php');
        $this->requireClass ('helper/json.php');
        $this->requireClass ('helper/utf8.php');
        $this->requireClass ('engine/action.php');
        $this->requireClass ('engine/controller.php');
        $this->requireClass ('engine/front.php');
        $this->requireClass ('engine/loader.php');
        $this->requireClass ('engine/model.php');
        $this->requireClass ('engine/registry.php');
        $this->requireClass ('library/cache.php');
        $this->requireClass ('library/url.php');
        $this->requireClass ('library/config.php');
        $this->requireClass ('library/db.php');
        $this->requireClass ('library/document.php');
        $this->requireClass ('library/encryption.php');
        $this->requireClass ('library/image.php');
        $this->requireClass ('library/language.php');
        $this->requireClass ('library/log.php');
        $this->requireClass ('library/mail.php');
        $this->requireClass ('library/pagination.php');
        $this->requireClass ('library/request.php');
        $this->requireClass ('library/response.php');
        $this->requireClass ('library/session.php');
        $this->requireClass ('library/template.php');

    }











}