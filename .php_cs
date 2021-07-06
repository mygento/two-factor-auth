<?php
$header = <<<EOF
@author Mygento Team
@copyright 2021 Mygento (https://www.mygento.ru)
@package Mygento_TwoFactorAuth
EOF;

$finder = PhpCsFixer\Finder::create()->in('.')->name('*.phtml')->ignoreVCSIgnored(true);
$config = new \Mygento\CS\Config\Module($header);
$config->setFinder($finder);
return $config;
