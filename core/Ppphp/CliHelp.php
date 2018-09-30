<?php
namespace Ppphp;

class CliHelp
{
    public function newCtrl($file)
    {
        return "<?php
namespace ".MODULE."\\ctrl;

class ".$file." extends \\Ppphp
{
    public function index()
    {
        //put some
    }
}
";
    }
}