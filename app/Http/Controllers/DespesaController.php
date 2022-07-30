<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DespesaController extends Controller
{
    public function index(Request $request) {
        try {
            $page = $request->input("pagina", 1);

            // Resgatar os Deputados
            $deputados = (new DeputadoController())->GetDataFromAPI($page)->dados;

            // Somar as despesas individuais de cada um
            $despesasPorDeputado = [];

            foreach ($deputados as $key => $deputado) {
                $despesasPorDeputado[] = $this->SumOfCostPerDeputado($deputado);
            }

            $links = \App\Utils\Pagination::CalculateLinks($page);

            return view("despesas", [
                "despesas" => $despesasPorDeputado,
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
            $listOfCosts = $this->GetDespesaPorDeputado($deputado->id)->dados;
            $sumfOfCosts = 0;

            foreach ($listOfCosts as $key => $cost) {
                $sumfOfCosts += $cost->valorLiquido;
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

    public function GetDespesaPorDeputado(int $id): object {
        $cacheKey = "despesas-deputado-" . $id;
        $endpoint = env("DADOS_ABERTOS_API_URL") . "/deputados/" . $id . "/despesas";
        $result = null;

        if (Cache::has($cacheKey)) {
            $result = Cache::get($cacheKey);
        } else {
            $response = null;

            if (env("APP_ENV") == "local") {
                $response = Http::withOptions([
                        "verify" => false
                    ])
                    ->accept("application/json")
                    ->get($endpoint);
            } else {
                $response = Http::accept("application/json")
                ->get($endpoint);
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
