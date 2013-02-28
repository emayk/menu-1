<?php

if (App::environment() != 'local') {
    return;
}

Route::get(
    '/wingsline/menus/tests/{id?}',
    array (
        'as' => 'wingsline-menu-tests',
        function ($id = null) {
            if (!$id) {
                $id = 'index';
            }
            return View::make('menu::tests.' . $id)->with(array('dir'=>__DIR__, 'id' => $id));
        }
    )
);
