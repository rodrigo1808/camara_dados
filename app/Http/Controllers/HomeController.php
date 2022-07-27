<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    protected int $itensPerPage = 16;

    public function index(Request $request) {
        try {
            $currentPage = $request->query("pagina", 1);

            // Substituir por chamada para o banco
            $body = $this->GetDataFromAPI($currentPage);

            $firstItem = -3;
            $lastItem = 5;
            $links = [];

            for ($i = $firstItem; $i <= $lastItem; $i++) { 
                if ($i + $currentPage <= 0) {
                    continue;
                }

                if ($i == $firstItem) {
                    // Adicionar pagina anterior
                    $links[] = [
                        "label" => "Anterior",
                        "pagina" => $currentPage - 1,
                        "rel" => "anterior"
                    ];

                    continue;
                }

                if ($i == $lastItem) {
                    // Saber se é a última página?
                    $links[] = [
                        "label" => "Proximo",
                        "pagina" => $currentPage + 1,
                        "rel" => "proximo"
                    ];

                    continue;
                }

                $links[] = [
                    "label" => $i + $currentPage,
                    "pagina" => $i + $currentPage,
                    "rel" => $i + $currentPage == $currentPage ? "atual" : "",
                ];
            }
    
            return view("home", [
                "dados" => $body->dados,
                "links" => $links
            ]);        
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function GetDataFromAPI(int $page): object {
        $result = null;

        if (Cache::has("deputados-lista-" . $page)) {
           $result = Cache::get("deputados-lista-" . $page);
        } else {
            if (env("APP_ENV") == "local") {
                $response = Http::withOptions([
                        "verify" => false
                ])
                ->accept("application/json")
                ->get(env("DADOS_ABERTOS_API_URL") . "/deputados", [
                    "itens" => $this->itensPerPage,
                    "pagina" => $page
                ]);
        } else {
            $response = Http::accept("application/json")
            ->get(env("DADOS_ABERTOS_API_URL") . "/deputados", [
                "itens" => $this->itensPerPage,
                "pagina" => $page
            ]);
        }
            
            if ($response->failed()) {
                throw new \Exception("Ocorreu um erro durante a requesição da API");
            }

            $result = $response->body();

            Cache::put("deputados-lista-" . $page, $result, now()->addMonthNoOverflow());
        }


        return json_decode($result);
    }
}
