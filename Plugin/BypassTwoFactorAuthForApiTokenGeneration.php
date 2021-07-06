<?php

namespace Mygento\TwoFactorAuth\Plugin;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\AuthenticationException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Integration\Api\AdminTokenServiceInterface;
use Magento\TwoFactorAuth\Model\AdminAccessTokenService;

class BypassTwoFactorAuthForApiTokenGeneration
{
    public const XML_PATH_CONFIG_ENABLED_FOR_API_TOKEN_GENERATION = 'twofactorauth/general/enabled_for_api_token_generation';

    /**
     * @var AdminTokenServiceInterface
     */
    private $adminTokenService;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        AdminTokenServiceInterface $adminTokenService,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->adminTokenService = $adminTokenService;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @param AdminAccessTokenService $subject
     * @param Closure $proceed
     * @param $username
     * @param $password
     * @throws AuthenticationException
     * @throws InputException
     * @throws LocalizedException
     * @return string
     */
    public function aroundCreateAdminAccessToken(AdminAccessTokenService $subject, \Closure $proceed, $username, $password): string
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_CONFIG_ENABLED_FOR_API_TOKEN_GENERATION)
            ? $proceed($username, $password)
            : $this->adminTokenService->createAdminAccessToken($username, $password);
    }
}
