<?php

namespace Prizym\View\Helper;

use Cob\View\Helper\HelperAbstract;

class ThemePath extends HelperAbstract
{

    private $path;

    public function themePath($asset=null)
    {
        $path = $this->path;

        if(null !== $asset){
            $path .= "/$asset";
        }

        return $path;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

}