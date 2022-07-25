<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index() {
        $response = null;

        // Substituir por chamada para o banco
        if (env("APP_ENV") == "local") {
            $response = Http::withOptions([
                    "verify" => false
                ])
                ->accept("application/json")
                ->get(env("DADOS_ABERTOS_API_URL") . "/deputados", [
                    "itens" => 10
                ]);
        } else {
            $response = Http::accept("application/json")
            ->get(env("DADOS_ABERTOS_API_URL") . "/deputados", [
                "itens" => 10
            ]);
        }
        
        if ($response->failed()) {
            // Exibir página com erro
        }

        $jsonBody = json_decode($response->body());

        return view("home", [
            "dados" => $jsonBody->dados
        ]);
    }
}
