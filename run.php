<?php

define('AUTOLOADER', 'autoloader.php');

class Server extends Thread
{
    public function __construct()
    {
        //$this->start(PTHREADS_INHERIT_ALL | PTHREADS_ALLOW_GLOBALS);
    }

    public function test()
    {
        return null;
    }

    public function run()
    {
        $callback = array($this, 'test');

        // it'll work by only doing that too:
        // $this;

        $a = require 'req01.php';
        /*
        $b = require 'req02.php';
        $c = require 'req03.php';
        $d = require 'req04.php';
        */

        //var_dump(array_keys($GLOBALS));
        $application = new Application();
        $application->join();
    }
}

class Application extends Thread
{

    public function __construct()
    {
        $this->start(PTHREADS_INHERIT_ALL | PTHREADS_ALLOW_GLOBALS);
    }

    public function getThis() {
        return $this;
    }

    public function run()
    {
        $this->afterdump = true;
        $x1 = new stdClass();
        $x2 = new stdClass();
        /*
        $a = require 'req01.php';
        $b = require 'req02.php';
        $c = require 'req03.php';
        $d = require 'req04.php';
        */
        $GLOBALS['this']->test = 'test';
        $GLOBALS['this']->x1 = $x1;
        $GLOBALS['this']->x2 = $x2;

        //var_dump(array_keys($GLOBALS));
        var_dump(get_class($GLOBALS['this']));

        usleep(10000);

        echo PHP_EOL . '[Application] dumping $GLOBALS[\'server\']:' . PHP_EOL;
        var_dump($GLOBALS['server']);

        usleep(10000);

        echo PHP_EOL . '[Application] dumping $GLOBALS[\'this\']:' . PHP_EOL;
        var_dump($GLOBALS['this']);


    }
}

$a = [];
for ($i=0; $i<100; $i++) {
    $a[] = new stdClass();
}

$server = new Server();
$server->start(PTHREADS_INHERIT_ALL | PTHREADS_ALLOW_GLOBALS);

usleep(5000);

echo PHP_EOL . '[GLOBAL] dumping $server:' . PHP_EOL;
$server->x1 = 'asdf';

var_dump($server);

echo "finished script..." . PHP_EOL;
