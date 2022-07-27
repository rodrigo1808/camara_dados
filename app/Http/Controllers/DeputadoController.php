<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DeputadoController extends Controller
{
    protected int $itensPerPage = 16;

    public function index(Request $request) {
        try {
            $currentPage = $request->query("pagina", 1);

            // Substituir por chamada para o banco
            $body = $this->GetDataFromAPI($currentPage);
            $links = $this->CalculateLinks((int) $currentPage);
    
            return view("deputados", [
                "dados" => $body->dados,
                "links" => $links
            ]);        
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(Request $request, int $id) {
        try {
            $deputado = $this->GetDeputadoFromAPI($id);

            return view("deputado.detalhes", [
                "deputado" => $deputado->dados
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function GetDataFromAPI(int $page): object {
        $cacheKey = "deputados-lista-" . $page;
        $result = null;

        if (Cache::has($cacheKey)) {
           $result = Cache::get($cacheKey);
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

            Cache::put($cacheKey, $result, now()->addMonthNoOverflow());
        }


        return json_decode($result);
    }

    protected function GetDeputadoFromAPI(int $id): object {
        $cacheKey = "deputado-detalhes-" . $id;
        $result = [];

        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
        } else {
            if (env("APP_ENV") == "local") {
                $response = Http::withOptions([
                        "verify" => false
                    ])
                    ->accept("application/json")
                    ->get(env("DADOS_ABERTOS_API_URL") . "/deputados/" . $id);
            } else {
                $response = Http::accept("application/json")
                ->get(env("DADOS_ABERTOS_API_URL") . "/deputados/" . $id);
            }
            
            if ($response->failed()) {
                throw new \Exception("Ocorreu um erro durante a requesição da API");
            }

            $result = $response->body();

            Cache::put($cacheKey, $result, now()->addMonthNoOverflow());
        }

        return json_decode($result);
    }

    protected function CalculateLinks(int $currentPage): array {
        $firstItem = -3;
        $lastItem = 5;
        $result = [];

        for ($i = $firstItem; $i <= $lastItem; $i++) { 
            $relativePage = $i + $currentPage;

            if ($relativePage <= 0)
                continue;

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
                // Como saber se é a última página?
                $links[] = [
                    "label" => "Proximo",
                    "pagina" => $currentPage + 1,
                    "rel" => "proximo"
                ];

                continue;
            }

            $result[] = [
                "label" => $relativePage,
                "pagina" => $relativePage,
                "rel" => $relativePage == $currentPage ? "atual" : "",
            ];
        }

        return $result;
    }
}
