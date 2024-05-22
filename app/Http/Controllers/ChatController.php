<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;


class ChatController extends Controller
{
    public function responselocal(Request $request) 
    {
        $data = ['message' => $request->input('message')];
        $response = Http::post('http://localhost:5000/predict', $data);
        if ($response->successful() && !empty($response->json())) {
            return response()->json($response->json());
        } else {
            $responsenotconnect = ['response'=>'Chat trying to connecting! please try again'];
            return $responsenotconnect;
        }
    }

    public function responsegpt(Request $request): JsonResponse
    {
        $search = $request->input('message');

        $data = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),

            // using api Open
            ])->post('https://api.openai.com/api',[
            'model' => 'davinci-002',
            'messages' => [
                [
                "role" => 'system',
                "content" => $search
                ]
            ],
            'temperature' => 0.5,
            'max_tokens' => 200,
            'top_p' => 1.0,
            'frequency_penalty' => 0.52,
            'presence_penalty' => 0.5,
            'stop' => ["11."],
        ])->json();

        return response()->json($data['choices'][0]['message'],200,array(),JSON_PRETTY_PRINT);
    
    }

    public function testapi()
    {
        $masukan = 'halo';
        $data1 = ['masuk', 'keluar'];
        $data2 = [1, 2, 3, 4, 5, $masukan];
        return response()->json([
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }
    public function posttestapi(Request $request)
    {
        $newData = $request->input('newData');
        $data1 = ['masuk', 'keluar'];
        $data2 = [1, 2, 3, 4, 5, $newData];
        return response()->json([
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }
}