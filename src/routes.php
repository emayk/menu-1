<?php

if (App::environment() != 'local') {
    return;
}

// sample route to menu manager
Route::group(
    array('prefix'=>'wingsline/menu'),
    function () {

        // menu test pages
        // Route::get(
        //     'tests/{id?}',
        //     array (
        //         'as' => 'wingsline-menu-tests',
        //         function ($id = null) {
        //             if (!$id) {
        //                 $id = 'index';
        //             }
        //             return View::make('menu::tests.' . $id)->with(array('dir'=>__DIR__, 'id' => $id));
        //         }
        //     )
        // );

        // menu tests resourceful controller
        Route::resource(
            'tests',
            'Wingsline\\Menu\\Controllers\\TestController',
            array('only' => array('index', 'show'))
        );

        // documentation resourceful controller
        Route::resource(
            'docs',
            'Wingsline\\Menu\\Controllers\\DocController',
            array('only' => array('index', 'show'))
        );
        
        // get a menu type's html with json
        Route::get(
            'itemtype/{type?}',
            array('uses' => 'Wingsline\\Menu\\Controllers\\MenuController@itemType', 'as'=>'admin.itemtype')
        )->where('type', '^[a-zA-Z][A-Za-z0-9_]+$');

        // menu admin resourceful controller
        Route::resource('admin', 'Wingsline\\Menu\\Controllers\\MenuController');
    }
);
// Event::listen('illuminate.query', function ($sql) {
//     var_dump($sql);
// });
