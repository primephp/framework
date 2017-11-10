<?php

/*
 * The MIT License
 *
 * Copyright 2017 TomSailor.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Prime\Util;

/**
 * @name Uuid
 * @package Prime\Util
 * @since 09/11/2017
 * @author TomSailor
 */
class Uuid
{

    private static function split($str32)
    {
        $s = str_split($str32, 4);
        return $s[0] . $s[1] . '-' . $s[2] . '-' . $s[3] . '-' . $s[4] . '-' . $s[5] . $s[6] . $s[7];
    }

    public static function md5($str)
    {
        return self::split(md5($str));
    }

    public static function generate()
    {
        $randon = str_pad(rand(), 10, '0', STR_PAD_LEFT);

        $uniqid = str_replace('.', '', uniqid('', true));

        return self::split($uniqid . $randon);
    }

    public static function create($prefix)
    {
        return self::split(md5(uniqid($prefix, true)));
    }

}
