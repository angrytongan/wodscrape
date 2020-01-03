<?php

require_once("./lib/hquery.php");

class scrape {
    public static function do_scrape($url, $sel, $title, $html = '') {
        $out = '';
        $error = NULL;

        $config = array(
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.99 Safari/537.36',
            'accept_html' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        );

        hQuery::$cache_path = sys_get_temp_dir() . '/hQuery/';

        try {
            if (empty($html)) {
                $doc = hQuery::fromUrl(
                    $url
                        , array(
                        'Accept'     => $config['accept_html'],
                        'User-Agent' => $config['user_agent'],
                    )
                );
            } else {
                $doc = hQuery::fromHTML($html);
            }

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

date_default_timezone_set('UTC');
