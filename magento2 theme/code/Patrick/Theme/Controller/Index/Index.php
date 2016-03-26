<?php
/* Created by Patrick Flores
   http://www.patrickflores.io
   Copyright © 2016. All rights reserved.
*/

namespace Patrick\Theme\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action {
    /* @var \Magento\Framework\View\Result\PageFactory */
  protected $resultPageFactory;
  public function __construct(\Magento\Framework\App\Action\Context $context,\Magento\Framework\View\Result\PageFactory $pageFactory) {
    parent::__construct($context);
    $this->resultPageFactory = $pageFactory;
  }

    public function execute() {
      $result = $this->resultPageFactory->create();
      return $result;
    }
}
