<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DeputadoController extends Controller
{
    protected int $itensPerPage = 16;

    public function index(Request $request) {
        try {
            $currentPage = $request->query("pagina", 1);

            // $body = $this->GetDataFromAPI($currentPage);
            $body = DB::select("
                select deputados.id, deputados.nome, deputados.url_foto, partidos.sigla as partido_sigla
                from deputados
                inner join partidos on deputados.partido_id=partidos.id
                order by deputados.nome asc
                limit ? offset ?
            ", [$this->itensPerPage, $this->itensPerPage * ($currentPage - 1)]);

            $links = \App\Utils\Pagination::CalculateLinks((int) $currentPage);
    
            return view("deputados", [
                "dados" => $body,
                "links" => $links
            ]);        
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(Request $request, int $id) {
        try {
            // $deputado = $this->GetDeputadoFromAPI($id);
            $deputado = DB::select("
                select deputados.*, partidos.id as partido_id, partidos.nome as partido_nome, partidos.sigla as partido_sigla
                from deputados
                inner join partidos on deputados.partido_id=partidos.id
                where deputados.id = ?
            ", [$id]);

            return view("deputado.detalhes", [
                "deputado" => $deputado[0]
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function GetDataFromAPI(int $page): object {
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

    public function GetDeputadoFromAPI(int $id): object {
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
}
