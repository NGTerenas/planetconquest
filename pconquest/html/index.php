<?php
//phpinfo();
/**
 * Bootstrap Zend Framework
 * 
 * @author  Olivier Madre
 * @version $Id: index.php,v 1.1 2009/02/18 15:47:09 madre-o Exp $
 */

// STEP 1 : Configuration - Chargement des constantes applicatives et environnementales.
// Positionnement de l'arborescence dans l'include_path pour chargement automatique des fichiers
include_once("../config/constantes-framework.php");
include_once("../config/constantes-exploitation.php");
include_once("../config/constantes-application.php");
set_include_path(
   '.' . PATH_SEPARATOR
 . LIBRARY_DIR . PATH_SEPARATOR
 . ZEND_DIR . PATH_SEPARATOR
 . MODEL_DIR . PATH_SEPARATOR
 . CONTROLLER_DIR . PATH_SEPARATOR
 );

date_default_timezone_set(APPLICATION_TIMEZONE);
 
// STEP 2 : Autoloader - Activation de l'auto-chargement des classes 
// enable autoloader ?

require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);

// STEP 3 : Session - Activation de la session avant toute sortie IHM
Zend_Session::start();

// STEP 4 : Initialisation - Cr�ation des objets applicatifs indispensables
// Cr�ation de la collection de route pour les redirections d'url rewriting
// Cr�ation de la collection de base de donn�es pour les acc�s DB
// Initialisation du module de debug si DISPLAY_DEBUG === true
include_once(INITIALISATION_FILE);

// STEP 5 : Front Controller - Pr�paration du Front Controller
// Enregistrement des plugins
// Enregistrement des chemins d'acc�s
// Enregistrement des routes
// Enregistrement du mode d'affichage
$oFrontController = Zend_Controller_Front::getInstance();
$oFrontController->registerPlugin(new Plugin_Acl());
$oFrontController->setControllerDirectory(CONTROLLER_DIR);
$oFrontController->setDefaultModule('frontend');
$oFrontController->addModuleDirectory(MODULE_DIR);
$oFrontController->throwExceptions(DISPLAY_EXCEPTION);
$route = Route_Service::getInstance()->setFrontController($oFrontController)->loadRoutes($oRouteCollection);

// STEP 6 : Layout - Activation du layout pour le 2 step views
Zend_Layout::startMvc()->setLayoutPath(LAYOUT_DIR);

// STEP 7 : Execution
$oFrontController->dispatch();
