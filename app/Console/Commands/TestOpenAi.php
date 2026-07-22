<?php

namespace App\Console\Commands;

use App\Models\MightyCall;
use App\Services\MightyCallService;
use Illuminate\Console\Command;
use OpenAI\Laravel\Facades\OpenAI;

class TestOpenAi extends Command
{
    protected $signature = 'openai.test'; // command to test
    protected $description = 'test the openai api';
    public function handle(){
        $this->info('testing openai api');
        $apiKey = config('openai.api_key');
        if(empty($apiKey)){
            $this->error('openai Api is not set in env');
            $this->info('please add openai key in .env file');
            return 1;
        } 
        try {
            $this->info('sending a request to open api');
            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user' , 
                    'content' => 'hello! this is testing ',
                    'message' => 'hu']
                    ],

                ]);
                $response = $result->choices[0]->message->content;
                $this->success('response recived' . $response);
                $this->info('openapi key is valid');

            
        } catch (\Exception $e) {
            $this->error('An error occured:' . $e->getMessage());

            //throw $th;
        } 

    }
    private function success($message){
$this->line('<fg=green;options=bold>' . $message . '</>');
    }
}
