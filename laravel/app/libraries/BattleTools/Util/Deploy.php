<?php

namespace BattleTools\Util;

use Illuminate\Support\Facades\Config;
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

        $cd = Config::get('deploy.path-to-branch');
        $cd = str_replace('{branch}', $branch, $cd);

        foreach(Config::get('deploy.pre-commands') as $command){
            $command = str_replace('{branch}', $branch, $command);
            $output[$command] = self::runProcess($command, $cd);
        }

        $masterBranch = Config::get('deploy.master-branch');
        $devBranch = Config::get('deploy.developer-branch');

        if(($branch == $masterBranch && Config::get('deploy.minify-master')) || ($branch == $devBranch && Config::get('deploy.minify-development'))){
            $doMinify = Config::get('deploy.files-to-minify');

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

        foreach(Config::get('deploy.post-commands') as $command){
            $command = str_replace('{branch}', $branch, $command);
            $output[$command] = self::runProcess($command, $cd);
        }

        return $output;
    }

    public static function minify($file, $branch, $cd, $timeout=180){
        $appendMin = self::appendMin($file);

        $type = $appendMin['type'];
        $fileMin = $appendMin['newFile'];

        if($type == 'css'){
            $process = 'java -jar '.Config::get('deploy.compiler').' --js '.$cd.'/'.$file.' --js_output_file '.$cd.'/'.$fileMin;
        }else if($type == 'js'){
            $process = 'java -jar '.Config::get('deploy.compiler-stylesheets').' '.$cd.'/'.$file.' > '.$cd.'/'.$fileMin;
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
