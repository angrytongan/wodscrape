<?php

require_once("./lib/hquery.php");

class scrape {
    public static function do_scrape($url, $sel, $title) {
        $out = '';
        $error = NULL;

        $config = array(
            'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
            'accept_html' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        );

        hQuery::$cache_path = sys_get_temp_dir() . '/hQuery/';

        try {
            $doc = hQuery::fromUrl(
                $url
                    , array(
                    'Accept'     => $config['accept_html'],
                    'User-Agent' => $config['user_agent'],
                )
            );

            if($doc) {
                $elements = $doc->find($sel);
            } else {
                $error = "Failed to find ${sel} in ${url}";
            }
        }
        catch(Exception $ex) {
            $error = $ex;
        }

        if ($error === NULL) {
            if ($elements) {
                foreach ($elements as $pos => $el) {
                    $out .= $el->outerHtml();
                }
            }
        }

        return array("result" => $out, "error" => $error);
    }

    public static function do_output($url, $title, $out) {
        echo "<h2><a href=\"${url}\" target=\"_blank\">${title}</a></h2>\n";
        if ($out['error']) {
            echo "<p class=\"error\">${out['error']}</p>";
        } else {
            echo $out['result'];
        }
    }
};
