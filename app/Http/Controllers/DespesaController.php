<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DespesaController extends Controller
{
    protected int $itensPerPage = 16;

    public function index(Request $request) {
        try {
            $page = $request->input("pagina", 1);

            // $deputados = (new DeputadoController())->GetDataFromAPI($page)->dados;

            // Somar as despesas individuais de cada um
            $despesasPorDeputado = DB::select("
                select deputados.id, deputados.nome, deputados.partido_id, partidos.id as partido_id, partidos.nome as partido_nome, despesas.deputado_id, SUM(despesas.valor_liquido) as despesa_total
                from deputados
                inner join partidos on deputados.partido_id=partidos.id
                inner join despesas on deputados.id=despesas.deputado_id
                group by despesas.deputado_id, deputados.id, deputados.nome, deputados.partido_id, partidos.id, partidos.nome, despesas.deputado_id
                limit ? offset ?
            ", [$this->itensPerPage, $this->itensPerPage * ($page - 1)]);

            $links = \App\Utils\Pagination::CalculateLinks($page);

            return view("despesas", [
                "despesasPorDeputado" => $despesasPorDeputado,
                "links" => $links
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show(Request $request, int $id) {
        try {
            $page = $request->query("pagina", 1);

            $deputado = (new DeputadoController())->GetDeputadoFromDB($id);

            // $despesas = $this->GetDespesaPorDeputado($id, $page)->dados;
            $despesas = DB::select("
                select * 
                from despesas
                where despesas.deputado_id=?
                order by data desc
                limit ? offset ?
            ", [$id, $this->itensPerPage, $this->itensPerPage * ($page - 1)]);

            $links = \App\Utils\Pagination::CalculateLinks($page);

            return view("deputado.despesas", [
                "deputado" => $deputado,
                "despesas" => $despesas,
                "links" => $links
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function SumOfCostPerDeputado(object $deputado): object {
        $cacheKey = "soma-despesas-" . $deputado->id;
        $result = null;

        if (Cache::has($cacheKey)) {
           $result = Cache::get($cacheKey);
        } else {
            $initialPage = 1;
            $lastLinkQueryArr = [];

            $tmpCost = $this->GetDespesaPorDeputado($deputado->id, $initialPage);

            $lastLink = end($tmpCost->links);
            $lastLinkQueryString = parse_url($lastLink->href, PHP_URL_QUERY);
            
            if ($lastLinkQueryString == false) {
                throw "Erro ao interpretar URL da última página";
            }
            
            parse_str($lastLinkQueryString, $lastLinkQueryArr);
            $lastPage = $lastLinkQueryArr["pagina"];

            $sumfOfCosts = 0;
            foreach ($tmpCost->dados as $key => $cost) {
                $sumfOfCosts += $cost->valorLiquido;
            }
            $initialPage++;

            while($initialPage != $lastPage) {
                $listOfCosts = $this->GetDespesaPorDeputado($deputado->id, $initialPage)->dados;

                foreach ($listOfCosts as $key => $cost) {
                    $sumfOfCosts += $cost->valorLiquido;
                }

                $initialPage++;
            }

            $result = json_encode([
                "deputado_id" => $deputado->id,
                "deputado_nome" => $deputado->nome,
                "deputado_partido" => $deputado->siglaPartido,
                "custo_total" => $sumfOfCosts
            ]);

            Cache::put($cacheKey, $result, now()->addMonthNoOverflow());
        }

        return json_decode($result);
    }

    public function GetDespesaPorDeputado(int $id, int $page): object {
        $cacheKey = "despesas-deputado-" . $id . "-pagina-" . $page;
        $result = null;

        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
        } else {
            $endpoint = env("DADOS_ABERTOS_API_URL") . "/deputados/" . $id . "/despesas";
            $response = null;
            $query = [
                "ordem" => "DESC",
                "ordenarPor" => "dataDocumento",
                "pagina" => $page
            ];

            if (env("APP_ENV") == "local") {
                $response = Http::withOptions([
                        "verify" => false
                    ])
                    ->accept("application/json")
                    ->get($endpoint, $query);
            } else {
                $response = Http::accept("application/json")
                ->get($endpoint, $query);
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
