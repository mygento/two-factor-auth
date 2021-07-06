<?php

namespace Mygento\TwoFactorAuth\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\TwoFactorAuth\Model\TfaSession;

class BypassTwoFactorAuth
{
    private const XML_PATH_CONFIG_ENABLED = 'twofactorauth/general/enabled';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param TfaSession $subject
     * @param $result
     * @return bool
     */
    public function afterIsGranted(TfaSession $subject, $result): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLED)
            ? $result
            : true;
    }
}
