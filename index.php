<?php
include_once 'Epi.php';
Epi::init('route');
/*
 * This is a sample page whch uses EpiCode.
 * There is a .htaccess file which uses mod_rewrite to redirect all requests to index.php while preserving GET parameters.
 * The $_['routes'] array defines all uris which are handled by EpiCode.
 * EpiCode traverses back along the path until it finds a matching page.
 *  i.e. If the uri is /foo/bar and only 'foo' is defined then it will execute that route's action.
 * It is highly recommended to define a default route of '' for the home page or root of the site (yoursite.com/).
 */
getRoute()->get('/', array('MyClass', 'home'));
getRoute()->get('/xbingo/(\w+)', array('MyClass', 'xbingo'));
getRoute()->run(); 
/*
 * ******************************************************************************************
 * Define functions and classes which are executed by EpiCode based on the $_['routes'] array
 * ******************************************************************************************
 */
class MyClass
{
  static public function home()
  {
    echo '<h1>X Bingo - The Multiplication Game</h1>
          <ul>
            <li><a href="/simple-site">Call MyClass::MyMethod</a></li>
            <li><a href="/simple-site/sample">Call MyClass::MyOtherMethod</a></li>
            <li><a href="/simple-site/somepath/source">View the source of this page</a></li>
            </ul>
            <p><img src="https://github.com/images/modules/header/logov3-hover.png"></p>';
  }
  static public function xbingo($referrer)
  {
    window.location.href = "https://play.google.com/store/apps/details?id=com.kairos.ihw.xbingo.x_bingo&referrer="+{$referrer};;
  }
}
