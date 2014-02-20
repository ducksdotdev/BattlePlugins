<?php

namespace BattleTools\Util;

use Symfony\Component\Process\Process;
use Whoops\Example\Exception;

class Deploy {

    public static function run($payload=null, $timeout=180, $force='dev'){
        $payload = json_decode($payload, true);

        if($payload != null){
            $ref = $payload['ref'];
            $ref = explode('/', $ref);
            $branch = $ref[2];
        }else{
            $branch = $force;
        }

        $cd = '/home/battleplugins/'.$branch.'/BattlePlugins';

        $process = new Process('php artisan down', $cd.'/laravel');
        $process->start();

        while($process->isRunning()){}

        $process = new Process('git stash && git pull origin '.$branch, $cd);
        $process->start();

        while($process->isRunning()){}

        $output = $process->getOutput();
        $errors = $process->getErrorOutput();

        if($branch == 'master'){
            $doMinify = array(
                'laravel/public/assets/css/style.css',
                'laravel/public/assets/js/admin.js',
                'laravel/public/assets/js/scripts.js',
            );

            if($payload != null){
                foreach($payload['head_commit']['modified'] as $file){
                    if(in_array($file, $doMinify)){
                        $method = self::minify($file, $branch, $cd, $timeout);
                        $output .= $method['output'];
                        $errors .= $method['errors'];
                    }
                }
                foreach($payload['head_commit']['added'] as $file){
                    if(in_array($file, $doMinify)){
                        $method = self::minify($file, $branch, $cd, $timeout);
                        $output .= $method['output'];
                        $errors .= $method['errors'];
                    }
                }
            }else{
                foreach($doMinify as $file){
                    $method = self::minify($file, $branch, $cd, $timeout);
                    $output .= $method['output'];
                    $errors .= $method['errors'];
                }
            }
        }


        $process = new Process('git stash pop', $cd);
        $process->start();

        while($process->isRunning()){}

        $output .= $process->getOutput();
        $errors .= $process->getErrorOutput();

        $process = new Process('php artisan up', $cd.'/laravel');
        $process->start();

        while($process->isRunning()){}

        $output .= $process->getOutput();
        $errors .= $process->getErrorOutput();

        return array(
            'output' => $output,
            'errors' => $errors
        );
    }

    public static function minify($file, $branch, $cd, $timeout=180){
        if(ListSentence::endsWith($file, 'css')){
            $type = 'css';
        }else if(ListSentence::endsWith($file, 'js')){
            $type = 'js';
        }else{
            return new Exception();
        }

        $fileMin = str_replace('.'.$type, '.min.'.$type, $file);

        if($type == 'js'){
            $process = 'java -jar /home/tools/compiler.jar --js /home/battleplugins/'.$branch.'/BattlePlugins/'.$file.' --js_output_file /home/battleplugins/'.$branch.'/BattlePlugins/'.$fileMin;
        }else if($type == 'css'){
            $process = 'java -jar /home/tools/closure-stylesheets.jar /home/battleplugins/'.$branch.'/BattlePlugins/'.$file.' > /home/battleplugins/'.$branch.'/BattlePlugins/'.$fileMin;
        }

        $process = new Process($process, $cd);
        $process->setTimeout($timeout);
        $process->start();
        while($process->isRunning()){}

        return array(
            'output' => $process->getOutput(),
            'errors' => $process->getErrorOutput()
        );
    }
}
