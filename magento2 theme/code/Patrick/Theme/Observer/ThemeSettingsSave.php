<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Patrick\Theme\Observer;

use Magento\Framework\Event\ObserverInterface;

class ThemeSettingsSave implements ObserverInterface
{
    protected $pthemeMessageHandler;
    protected $pthemeCssGenerator;

    /**
     * @param \Magento\Backend\Helper\Data $backendData
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Framework\App\ResponseInterface $response
     */
     public function __construct(
         \Patrick\Theme\Model\CustomCssConfig\CustomCssConfigGenerator $pthemeCssModel,
         \Magento\Framework\Message\ManagerInterface $pthemeMessageManager
     ) {
         $this->pthemeCssGenerator = $pthemeCssModel;
         $this->pthemeMessageHandler = $pthemeMessageManager;
     }

    /**
     * Log out user and redirect to new admin custom url
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     * @SuppressWarnings(PHPMD.ExitExpression)
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $ptheme_message = 'Saved Patrick Theme Settings!';
        $this->pthemeCssGenerator->generateCss('settings', $observer->getData("website"), $observer->getData("store"));
    }
}
