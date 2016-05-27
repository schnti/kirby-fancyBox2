<?php

// fancybox tag
kirbytext::$tags['fb'] = array(
    'attr' => array(
        'width',
        'text',
        'class'
    ),
    'html' => function ($tag) {

        $url = $tag->attr('fb');
        $title = $tag->attr('text');
        $class = $tag->attr('class');

        $width = $tag->attr('width');

        $file = $tag->file($url);

        if (!$file)
            return ('<b>ERROR: Image not found</b>');

        if (empty($class)) {
            $class = c::get('ka.fancybox.imgclass', 'image-right');
        }

        if (empty($width)) {
            $width = c::get('ka.fancybox.small.width', 250);
        }

        $quality = c::get('ka.fancybox.quality', 100);


        if (empty($title)) {
            if ($file->text() != '') {
                $title = $file->text();
            } else {
                //                $title = pathinfo($url, PATHINFO_FILENAME);
            }
        }

        // link builder
        $_link = function ($image) use ($tag, $file, $title, $quality) {

            $width = c::get('ka.fancybox.big.width', 1000);
            $fancyBoxClass = c::get('ka.fancybox.linkclass', 'fancybox');

            $url = thumb($file, array('width' => $width, 'quality' => $quality))->url();

            return html::a(url($url), $image, array(
                'rel' => 'images',
                'class' => $fancyBoxClass,
                'title' => $title
            ));

        };

        // image builder
        $_image = function ($class) use ($tag, $file, $width, $title, $quality) {

            // $url = $file->url();
            $url = thumb($file, array('width' => $width, 'quality' => $quality))->url();


            return html::img($url, array(
                'class' => $class,
                'alt' => $title
            ));
        };

        return $_link($_image($class));
    }
);