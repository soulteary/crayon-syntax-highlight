<?php
/**
 * Crayon Syntax Highlighter Adapter
 *
 * @author soulteary
 * @date 2017.05.29
 */

error_reporting(E_ALL);

define('ROOT_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

$_SERVER['HTTP_USER_AGENT'] = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36";

define('ABSPATH', 'ABSPATH');

function is_admin()
{
    return true;
}

function home_url()
{
    return 'home_url';
}

function plugins_url()
{
    return 'plugins_url';
}

function wp_upload_dir()
{
    return array(
        'basedir' => 'wp_upload_dir basedir',
        'baseurl' => 'wp_upload_dir baseurl',
    );
}

function get_option()
{
    $args = func_get_args();

    if (count($args) === 1) {
        $filename = ROOT_DIR . $args[0] . '.json';
        if (file_exists($filename)) {
            $handle = fopen($filename, "r");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            return json_decode($contents, true);
        } else {
            return null;
        }
    } else {
        die('update option error.');
    }
}

function update_option()
{
    $args = func_get_args();

    if (count($args) === 2) {
        $fp = fopen(ROOT_DIR . $args[0] . '.json', 'w');
        fwrite($fp, trim(json_encode($args[1]), "\xEF\xBB\xBF"));
        fclose($fp);
    } else {
        die('update option error.');
    }
}

function shortcode_atts($pairs, $atts)
{
    $atts = (array)$atts;
    $out = array();
    foreach ($pairs as $name => $default) {
        if (array_key_exists($name, $atts))
            $out[$name] = $atts[$name];
        else
            $out[$name] = $default;
    }
    return $out;
}

function add_action()
{
    $args = func_get_args();

    if (count($args) === 2) {
        return $args[1]();
    } else {
//        die('1 args.');
    }
}

function register_activation_hook()
{

}

function register_deactivation_hook()
{
}

function add_options_page()
{
}

function wp_enqueue_style()
{

}

function wp_enqueue_script()
{

}

function admin_url()
{

}

function wp_localize_script()
{

}

function register_setting()
{

}

function add_settings_section()
{

}

function add_settings_field()
{

}

function add_filter()
{

}

function wp_deregister_script()
{

}

function wp_mkdir_p()
{

}

require_once 'util/theme-editor/theme_editor.php';
require_once 'crayon_wp.class.php';

if (isset($_POST['code']) && !empty($_POST['code'])) {
    $result = CrayonWP::highlight($_POST['code'], false, get_option('crayon_options'));
    $values = explode('plugins_url/fonts/monaco.css" />', $result);
//    die($values[1]);
    die(preg_replace(array('/>\s+</Um', '/>(\s+\n|\r)/', '/^\s+/'), array('><', '>', ''), $values[1]));
} else {
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            padding: 0;
            margin: 10px;
        }

        textarea {
            width: 100%;
            border-radius: 6px;
            outline: 0;
            line-height: 1.5;
            border: 1px solid #aeaeae;
            text-indent: 0.5rem;
            color: #666;
        }

        button {
            border: none;
        }

        .btn {
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
            text-decoration: none;
            margin: 4px 2px;
            color: #fff;
            position: relative;
            display: inline-block;
        }

        button:focus {
            outline: 0;
        }

        .btn:active {
            transform: translate(0px, 5px);
            -webkit-transform: translate(0px, 5px);
            box-shadow: 0px 1px 0px 0px;
        }

        .blue {
            background-color: #55acee;
            box-shadow: 0px 5px 0px 0px #3C93D5;
        }

        .blue:hover {
            background-color: #6FC6FF;
        }

    </style>
</head>
<body>

<form action="./index.php" method="post">
    <textarea name="code" cols="100" rows="20"></textarea>

    <button type="submit" class="btn blue">提交</button>

</form>
</body>
</html>
<?php
}
