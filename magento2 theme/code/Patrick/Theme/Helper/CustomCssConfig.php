<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Patrick\Theme\Helper;

class CustomCssConfig extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $pthemeStoreManager;
    protected $pthemeGeneratedCssFolder;
    protected $pthemeGeneratedCssPath;
    protected $pthemeGeneratedCssDir;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $pthemeStoreManagerModel
    ) {
        $this->pthemeStoreManager = $pthemeStoreManagerModel;
        $base = BP;
        $this->pthemeGeneratedCssFolder = 'Patrick/ptheme/assets/css/';
        $this->pthemeGeneratedCssPath = 'app/design/frontend/'.$this->pthemeGeneratedCssFolder;
        $this->pthemeGeneratedCssDir = $base.'/'.$this->pthemeGeneratedCssPath;
        parent::__construct($context);
    }

    public function getBaseMediaUrl()
    {
        return $this->pthemeStoreManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    public function getCssConfigDir()
    {
        return $this->pthemeGeneratedCssDir;
    }

    public function getSettingsFile()
    {
        return $this->getBaseMediaUrl(). $this->pthemeGeneratedCssFolder . 'custom.css';
    }

    public function getDesignFile()
    {
        return $this->getBaseMediaUrl(). $this->pthemeGeneratedCssFolder . 'design_' . $this->pthemeStoreManager->getStore()->getCode() . '.css';
    }
}
