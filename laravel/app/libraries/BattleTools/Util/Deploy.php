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
        $output[$command] = self::runProcess($command, $cd);

        $command = 'git stash && git pull origin '.$branch;
        $output[$command] = self::runProcess($command, $cd);

        if($branch == 'master'){
            $doMinify = Config::get('deploy.doMinify');

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
            $output[$command] = self::runProcess($command, $cd);
        }

        $command = 'php artisan up';
        $output[$command] = self::runProcess($command, $cd);

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

        return self::runProcess($process, $cd);
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

    public static function runProcess($command, $cd){
        $process = new Process($command, $cd);
        $process->start();

        while($process->isRunning()){}

        return array('output' => $process->getOutput(), 'errors' => $process->getErrorOutput());
    }

    public static function isDeveloperMode(){
        $subdomain = Subdomains::extractSubdomain(URL::to('/'));
        $subdomain = str_replace('http://', '', $subdomain);
        return $subdomain == 'dev';
    }
}
