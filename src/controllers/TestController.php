<?php

namespace Wingsline\Menu\Controllers;

class TestController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return \View::make('menu::tests.index')
            ->with('menuTestList', $this->getTests());
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($test)
    {
        return \View::make('menu::tests.' . $test)
            ->with('menuTestList', $this->getTests($test))
            ->with('menuTestType', $test);
    }

    // --------------------------------------------------------------
    // Protected functions
    // --------------------------------------------------------------
    /**
     * Returns the test links based on views
     *
     * @param  string $selected The currently selected test
     *
     * @return array
     */
    protected function getTests ($selected = '')
    {
        $dir = realpath(__DIR__ . '/../views/tests');
        $tests = array();
        foreach (\File::files($dir) as $file) {
            $file = pathinfo(pathinfo($file, PATHINFO_FILENAME), PATHINFO_FILENAME);
            if ($file == 'index') {
                continue;
            }
            $text = ucwords(str_replace('_', ' ', $file));
            if ($selected == $file) {
                $text = '<strong>' . $text . '</strong>';
            }
            $url = \URL::route('tests.show', array($file));
            $tests[] = '<a href="' . $url . '">' . $text . '</a>';
        }
        return $tests;
    }
}
