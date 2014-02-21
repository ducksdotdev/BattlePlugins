<?php

namespace BattleTools\Util;

use Illuminate\Support\Facades\URL;
use Psr\Log\InvalidArgumentException;
use Symfony\Component\Process\Process;

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

        $command = 'php artisan down';
        $process = new Process($command, $cd.'/laravel');
        $process->start();

        while($process->isRunning()){}

        $output[$command] = array('output' => $process->getOutput(), 'errors' => $process->getErrorOutput());

        $command = 'git stash && git pull origin '.$branch;
        $process = new Process($command, $cd);
        $process->start();

        while($process->isRunning()){}

        $gitError = $process->getErrorOutput();
        if(ListSentence::startsWith($gitError, 'From GitHub:'));

        $output[$command] = array('output' => $process->getOutput(), 'errors' => $gitError);

        if($branch == 'master'){
            $doMinify = array(
                'laravel/public/assets/css/style.css',
                'laravel/public/assets/js/admin.js',
                'laravel/public/assets/js/scripts.js',
            );

            if($payload != null){
                $files = $payload['head_commit']['modified'] + $payload['head_commit']['added'];

                foreach($files as $file){
                    if(in_array($file, $doMinify)){
                        $method = self::minify($file, $branch, $cd, $timeout);
                        $output['minify '.$file] = array('output'=>$method['output'],'errors' => $method['errors']);
                    }
                }
            }else{
                foreach($doMinify as $file){
                    $method = self::minify($file, $branch, $cd, $timeout);
                    $output['minify '.$file] = array('output'=>$method['output'],'errors' => $method['errors']);
                }
            }

            $command = 'git stash pop';
            $process = new Process($command, $cd);
            $process->start();

            while($process->isRunning()){}

            $output[$command] = array('output' => $process->getOutput(), 'errors' => $process->getErrorOutput());
        }

        $command = 'php artisan up';
        $process = new Process($command, $cd.'/laravel');
        $process->start();

        while($process->isRunning()){}

        $output[$command] = array('output' => $process->getOutput(), 'errors' => $process->getErrorOutput());

        return $output;
    }

    public static function minify($file, $branch, $cd, $timeout=180){
        $appendMin = self::appendMin($file);

        $type = $appendMin['type'];
        $fileMin = $appendMin['newFile'];

        if($type == 'css'){
            $process = 'java -jar /home/tools/compiler.jar --js /home/battleplugins/'.$branch.'/BattlePlugins/'.$file.' --js_output_file /home/battleplugins/'.$branch.'/BattlePlugins/'.$fileMin;
        }else if($type == 'js'){
            $process = 'java -jar /home/tools/closure-stylesheets.jar /home/battleplugins/'.$branch.'/BattlePlugins/'.$file.' > /home/battleplugins/'.$branch.'/BattlePlugins/'.$fileMin;
        }else{
            throw new InvalidArgumentException;
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

    public static function appendMin($file, $type=null){
        if($type == null){
            if(ListSentence::endsWith($file, 'css')){
                $type = 'css';
            }else if(ListSentence::endsWith($file, 'js')){
                $type = 'js';
            }else{
                throw new InvalidArgumentException;
            }
        }
        return array(
            'type' => $type,
            'newFile' => str_replace('.'.$type, '.min.'.$type, $file)
        );
    }

    public static function isDeveloperMode(){
        $subdomain = Subdomains::extractSubdomain(URL::to('/'));
        $subdomain = str_replace('http://', '', $subdomain);
        return $subdomain === 'dev';
    }
}
