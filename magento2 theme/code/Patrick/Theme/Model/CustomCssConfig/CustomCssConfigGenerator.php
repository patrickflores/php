<?php

namespace Patrick\Theme\Model\CustomCssConfig;

class CustomCssConfigGenerator
{
    protected $pthemeMessageManager;
    protected $pthemeCssConfigData;
    protected $pthemeRegistry;
    protected $pthemeStoreManager;
    protected $pthemeLayoutManager;

    public function __construct(
        \Patrick\Theme\Helper\CustomCssConfig $pthemeCssHelper,
        \Magento\Framework\Registry $pthemeCoreRegistry,
        \Magento\Store\Model\StoreManagerInterface $pthemeStoreManagerModel,
        \Magento\Framework\View\LayoutInterface $pthemeLayoutManagerView,
        \Magento\Framework\Message\ManagerInterface $pthemeMessage
    ) {
        $this->pthemeCssConfigData = $pthemeCssHelper;
        $this->pthemeRegistry = $pthemeCoreRegistry;
        $this->pthemeStoreManager = $pthemeStoreManagerModel;
        $this->pthemeLayoutManager = $pthemeLayoutManagerView;
        $this->pthemeMessageManager = $pthemeMessage;
    }

    public function generateCss($type, $websiteID, $storeID){
        if(!$websiteID && !$storeID) {
            $websites = $this->pthemeStoreManager->getWebsites(false, false);
            foreach ($websites as $id => $value) {
                $this->generateWebsiteCss($type, $id);
            }
        } else {
            if($storeID) {
                $this->generateStoreCss($type, $storeID);
            } else {
                $this->generateWebsiteCss($type, $websiteID);
            }
        }
    }

    protected function generateWebsiteCss($type, $websiteID) {
        $website = $this->pthemeStoreManager->getWebsite($websiteID);
        foreach($website->getStoreIds() as $storeID){
            $this->generateStoreCss($type, $storeID);
        }
    }
    protected function generateStoreCss($type, $storeID) {
        $store = $this->pthemeStoreManager->getStore($storeID);
        if(!$store->isActive())
            return;
        $storeCode = $store->getCode();
        $str1 = '_'.$storeCode;
        $str2 = 'custom.css';
        $str3 = $this->pthemeCssConfigData->getCssConfigDir().$str2;
        $str4 = 'css/'.$type.'.phtml';
        $this->pthemeRegistry->register('cssgen_store', $storeCode);

        try {
            $block = $this->pthemeLayoutManager->createBlock('Patrick\Theme\Block\Template')->setData('area','frontend')->setTemplate($str4)->toHtml();
            if(!file_exists($this->pthemeCssConfigData->getCssConfigDir())) {
                @mkdir($this->pthemeCssConfigData->getCssConfigDir(), 0777);
            }
            $file = @fopen($str3,"w+");
            @flock($file, LOCK_EX);
            @fwrite($file,$block);
            @flock($file, LOCK_UN);
            @fclose($file);
            if(empty($block)) {
                throw new \Exception( __("Template file doesn't exist: ".$str4) );
            }
        } catch (\Exception $e) {
            $this->pthemeMessageManager->addError(__('Failed Generating CSS Files: '.$str2.' in '.$this->pthemeCssConfigData->getCssConfigDir()).'<br/>Message: '.$e->getMessage());
        }
        $this->pthemeRegistry->unregister('ptheme_css_generator');
    }
}
