<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * PHP version 5
 *
 * Copyright (c) 2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>,
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package    stagehand-php-class-parser
 * @copyright  2009 KUMAKURA Yousuke <kumatch@users.sourceforge.net>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License (revised)
 * @version    Release: @package_version@
 * @since      File available since Release 0.1.0
 */
 
require_once 'PEAR/PackageFileManager2.php';
require_once 'PEAR.php';
 
PEAR::staticPushErrorHandling(PEAR_ERROR_CALLBACK, create_function('$error', 'var_dump($error); exit();'));
 
$releaseVersion = '0.1.0';
$releaseStability = 'beta';
$apiVersion = '0.1.0';
$apiStability = 'beta';
$notes = 'The initial release of Stagehand_PHP_Class_Parser.';
 
$package = new PEAR_PackageFileManager2();
$package->setOptions(array('filelistgenerator' => 'file',
                           'changelogoldtonew' => false,
                           'simpleoutput' => true,
                           'baseinstalldir' => '/',
                           'packagefile' => 'package.xml',
                           'packagedirectory' => '.',
                           'dir_roles' => array('bin' => 'script',
                                                'doc' => 'doc',
                                                'src' => 'php',
                                                'tests' => 'test'),
                           'ignore' => array('package.php'))
                     );
 
$package->setPackage('Stagehand_PHP_Class_Parser');
$package->setPackageType('php');
$package->setSummary('A parser class for a PHP class.');
$package->setDescription('Stagehand_PHP_Class_Parser provides features of the parsing and building to models (Stagehand_PHP_Class) for a PHP class.');
$package->setChannel('pear.piece-framework.com');
$package->setLicense('BSD License (revised)', 'http://www.opensource.org/licenses/bsd-license.php');
$package->setAPIVersion($apiVersion);
$package->setAPIStability($apiStability);
$package->setReleaseVersion($releaseVersion);
$package->setReleaseStability($releaseStability);
$package->setNotes($notes);
$package->setPhpDep('5.0.0');
$package->setPearinstallerDep('1.4.3');
$package->addMaintainer('lead', 'kumatch', 'KUMAKURA Yousuke', 'kumatch@gmail.com');
$package->addGlobalReplacement('package-info', '@package_version@', 'version');
$package->addPackageDepWithChannel('required', 'Stagehand_PHP_Parser', 'pear.piece-framework.com', '0.1.0');
$package->addPackageDepWithChannel('required', 'Stagehand_PHP_Lexer', 'pear.piece-framework.com', '0.1.0');
$package->addPackageDepWithChannel('required', 'Stagehand_PHP_Class', 'pear.piece-framework.com', '0.1.0');
$package->generateContents();
 
if (array_key_exists(1, $_SERVER['argv']) && $_SERVER['argv'][1] == 'make') {
    $package->writePackageFile();
} else {
    $package->debugPackageFile();
}
 
exit(); 

/*
* Local Variables:
* mode: php
* coding: iso-8859-1
* tab-width: 4
* c-basic-offset: 4
* c-hanging-comment-ender-p: nil
* indent-tabs-mode: nil
* End:
*/
