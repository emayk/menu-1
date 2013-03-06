<?php

namespace Wingsline\Menu\Controllers;

use dflydev\markdown\MarkdownExtraParser;

class DocController extends \BaseController
{
    public $markdownParser;

    public function __construct ()
    {
        $this->markdownParser = new MarkdownExtraParser();
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->show('usage');
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($doc)
    {
        $markdown = $this->getDoc($doc);
        if (!$markdown) {
            \App::abort(404);
        }
        $data['content'] = $this->markdownParser->transformMarkdown($markdown);
        $data['toc'] = $this->getToc($doc);
        return \View::make('menu::docs', $data);
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
    protected function getDoc ($doc)
    {
        $dir = realpath(__DIR__ . '/../../doc/');
        $file = $dir . '/' . $doc . '.md';
        if (file_exists($file)) {
            return file_get_contents($file);
        }
        
        // $tests = array();
        // foreach (\File::files($dir) as $file) {
        //     $file = pathinfo(pathinfo($file, PATHINFO_FILENAME), PATHINFO_FILENAME);
        //     if ($file == 'index') {
        //         continue;
        //     }
        //     $text = ucwords(str_replace('_', ' ', $file));
        //     if ($selected == $file) {
        //         $text = '<strong>' . $text . '</strong>';
        //     }
        //     $url = \URL::route('tests.show', array($file));
        //     $tests[] = '<a href="' . $url . '">' . $text . '</a>';
        // }
        // return $tests;
    }

    protected function getToc ($selected = '')
    {
        $dir = realpath(__DIR__ . '/../../doc/');
        $first = 'usage';
        $toc = array();
        $list = array();
        foreach (\File::files($dir, array('md')) as $file) {
            if (\File::extension($file) !== 'md') {
                continue;
            }
            $handle = fopen($file, "r");
            $contents = preg_split('/\r\n|\r|\n/', fread($handle, 1024));
            fclose($handle);
            $name = pathinfo(pathinfo($file, PATHINFO_FILENAME), PATHINFO_FILENAME);
            $list[$name] = trim(trim(array_shift($contents), '#'));
            if ($selected == $name) {
                $list[$name] = '<strong>' . $list[$name] . '</strong>';
            }
        }
        $firstItem = array($first => $list[$first]);
        unset($list[$first]);
        $list = array_filter(array_merge($firstItem, $list));
        
        foreach ($list as $doc => $label) {
            $toc[] = '<a href="' . \URL::route('docs.show', array($doc)) . '">' . $label . '</a>';
        }
        return $toc;
    }
}
