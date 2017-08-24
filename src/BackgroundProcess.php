<?php
namespace Dbseller;

/**
 * Created by PhpStorm.
 * User: harley
 * Date: 22/08/17
 * Time: 22:01
 */
class BackgroundProcess
{
    public static function open($exec, $cwd = null)
    {
        if (!is_string($cwd)) {
            $cwd = @getcwd();
        }

        @chdir($cwd);

        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $WshShell = new COM("WScript.Shell");
            $WshShell->CurrentDirectory = str_replace('/', '\\', $cwd);
            $WshShell->Run($exec, 0, false);
        } else {

            print exec($exec . " > /dev/null 2>&1 &");
        }
    }


}