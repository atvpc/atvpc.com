<?php
/**
 * @id PicoMenuHiding.php 01.Feb.2016
 * 
 * Description
 *
 * @author Uwe Fritz
 * @fork_from https://github.com/somepx/Pico-Hide
 * @link http://www.edor.de
 * @copyright Copyright (c) 2016 edor.de (Uwe Fritz)
 * @license MIT
 */


final class PicoMenuHiding extends AbstractPicoPlugin {

    /**
     * This plugin is enabled by default?
     *
     * @see AbstractPicoPlugin::$enabled
     * @var boolean
     */
    protected $enabled = FALSE;

    /**
     * This plugin depends on ...
     *
     * @see AbstractPicoPlugin::$dependsOn
     * @var string[]
     */
    protected $dependsOn = array();


    /**
     * Triggered after Pico has loaded all available plugins
     *
     * This event is triggered nevertheless the plugin is enabled or not.
     * It is NOT guaranteed that plugin dependencies are fulfilled!
     *
     * @see    Pico::getPlugin()
     * @see    Pico::getPlugins()
     *
     * @param  object[] &$plugins loaded plugin instances
     *
     * @return void
     */
    public
    function onPluginsLoaded( array &$plugins ) {
        // your code
    }


    /**
     * Triggered after Pico has read its configuration
     *
     * @see    Pico::getConfig()
     *
     * @param  mixed[] &$config array of config variables
     *
     * @return void
     */
    public
    function onConfigLoaded( array &$config ) {
        // your code
    }


    /**
     * Triggered when Pico reads its known meta header fields
     *
     * @see    Pico::getMetaHeaders()
     *
     * @param  string[] &$headers list of known meta header
     *                            fields; the array value specifies the YAML key to search for, the
     *                            array key is later used to access the found value
     *
     * @return void
     */
    public
    function onMetaHeaders( array &$headers ) {

        // your code
        $headers[ 'hiding' ] = 'Hiding';
    }


    /**
     * Triggered when Pico reads a single page from the list of all known pages
     *
     * The `$pageData` parameter consists of the following values:
     *
     * | Array key      | Type   | Description                              |
     * | -------------- | ------ | ---------------------------------------- |
     * | id             | string | relative path to the content file        |
     * | url            | string | URL to the page                          |
     * | title          | string | title of the page (YAML header)          |
     * | description    | string | description of the page (YAML header)    |
     * | author         | string | author of the page (YAML header)         |
     * | time           | string | timestamp derived from the Date header   |
     * | date           | string | date of the page (YAML header)           |
     * | date_formatted | string | formatted date of the page               |
     * | raw_content    | string | raw, not yet parsed contents of the page |
     * | meta           | string | parsed meta data of the page             |
     *
     * @see    DummyPlugin::onPagesLoaded()
     *
     * @param  array &$pageData data of the loaded page
     *
     * @return void
     */
    public
    function onSinglePageLoaded( array &$pageData ) {

        // your code
        $pageData[ 'hiding' ] = isset( $pageData[ 'meta' ][ 'hiding' ] ) ? intval( $pageData[ 'meta' ][ 'hiding' ] ) : 0;
    }


    /**
     * Triggered after Pico has read all known pages
     *
     * See {@link DummyPlugin::onSinglePageLoaded()} for details about the
     * structure of the page data.
     *
     * @see    Pico::getPages()
     * @see    Pico::getCurrentPage()
     * @see    Pico::getPreviousPage()
     * @see    Pico::getNextPage()
     *
     * @param  array[]    &$pages        data of all known pages
     * @param  array|null &$currentPage  data of the page being served
     * @param  array|null &$previousPage data of the previous page
     * @param  array|null &$nextPage     data of the next page
     *
     * @return void
     */
    public
    function onPagesLoaded( array &$pages, array &$currentPage = NULL, array &$previousPage = NULL, array &$nextPage = NULL ) {

        // your code
        $clean_menu_pages = array();

        foreach ( $pages as $page ) {
            if ( ( $page[ 'hiding' ] == 1 ) && ( !preg_match( '/admin/', $_SERVER[ 'REQUEST_URI' ] ) ) ) {
                // hide this entry from the menu, if not in admin
            }
            else {
                $clean_menu_pages[] = $page;
            }
        }
        $pages = $clean_menu_pages;

    }

}
