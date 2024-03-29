<?php

/*
|--------------------------------------------------------------------------
| Menu filter
|--------------------------------------------------------------------------
| 
| This filter will replace the menu uuid's with the actual menus providing
| an optimized approach to get all the menus for the page from the database
| once
| 
*/

App::after(
    function ($request, $response) {
        if (is_callable(array($response, 'getOriginalContent')) && $response->getOriginalContent() instanceof Illuminate\Support\Contracts\RenderableInterface) {
            // we compile the menus and replace the menu uuid's with the menu
            Menu::finalize($response);
        }
    }
);
