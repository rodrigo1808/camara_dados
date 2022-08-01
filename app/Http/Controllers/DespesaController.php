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
    protected $fixedReturn = [
        '[ { "id": 62881, "nome": "Danilo Forte", "partido_id": 38009, "partido_nome": "União Brasil", "deputado_id": 62881, "despesa_total": "316428" }, { "id": 66179, "nome": "Norma Ayub", "partido_id": 37903, "partido_nome": "Progressistas", "deputado_id": 66179, "despesa_total": "182100" }, { "id": 66828, "nome": "Fausto Pinato", "partido_id": 37903, "partido_nome": "Progressistas", "deputado_id": 66828, "despesa_total": "411916" }, { "id": 68720, "nome": "Fábio Henrique", "partido_id": 38009, "partido_nome": "União Brasil", "deputado_id": 68720, "despesa_total": "218549" }, { "id": 69871, "nome": "Bacelar", "partido_id": 36851, "partido_nome": "Partido Verde", "deputado_id": 69871, "despesa_total": "627971" }, { "id": 72442, "nome": "Felipe Carreras", "partido_id": 36832, "partido_nome": "Partido Socialista Brasileiro", "deputado_id": 72442, "despesa_total": "267893" }, { "id": 73433, "nome": "Arlindo Chinaglia", "partido_id": 36844, "partido_nome": "Partido dos Trabalhadores", "deputado_id": 73433, "despesa_total": "425231" }, { "id": 73441, "nome": "Celso Russomanno", "partido_id": 37908, "partido_nome": "Republicanos", "deputado_id": 73441, "despesa_total": "109549" }, { "id": 73460, "nome": "Gustavo Fruet", "partido_id": 36786, "partido_nome": "Partido Democrático Trabalhista", "deputado_id": 73460, "despesa_total": "328697" }, { "id": 73463, "nome": "Osmar Serraglio", "partido_id": 37903, "partido_nome": "Progressistas", "deputado_id": 73463, "despesa_total": "192877" }, { "id": 73466, "nome": "Rubens Bueno", "partido_id": 37905, "partido_nome": "Cidadania", "deputado_id": 73466, "despesa_total": "342844" }, { "id": 73482, "nome": "Henrique Fontana", "partido_id": 36844, "partido_nome": "Partido dos Trabalhadores", "deputado_id": 73482, "despesa_total": "264791" }, { "id": 73486, "nome": "Pompeo de Mattos", "partido_id": 36786, "partido_nome": "Partido Democrático Trabalhista", "deputado_id": 73486, "despesa_total": "115569" }, { "id": 73531, "nome": "Ivan Valente", "partido_id": 36839, "partido_nome": "Partido Socialismo e Liberdade", "deputado_id": 73531, "despesa_total": "585185" }, { "id": 73586, "nome": "Júlio Delgado", "partido_id": 36851, "partido_nome": "Partido Verde", "deputado_id": 73586, "despesa_total": "211671" }, { "id": 73604, "nome": "Rui Falcão", "partido_id": 36844, "partido_nome": "Partido dos Trabalhadores", "deputado_id": 73604, "despesa_total": "523274" } ]',
        '[ { "id": 73692, "nome": "Osmar Terra", "partido_id": 36899, "partido_nome": "Movimento Democrático Brasileiro", "deputado_id": 73692, "despesa_total": "181659" }, { "id": 73696, "nome": "Angela Amin", "partido_id": 37903, "partido_nome": "Progressistas", "deputado_id": 73696, "despesa_total": "324943" }, { "id": 73701, "nome": "Benedita da Silva", "partido_id": 36844, "partido_nome": "Partido dos Trabalhadores", "deputado_id": 73701, "despesa_total": "508943" }, { "id": 73772, "nome": "Hermes Parcianello", "partido_id": 36899, "partido_nome": "Movimento Democrático Brasileiro", "deputado_id": 73772, "despesa_total": "462357" }, { "id": 73788, "nome": "Ricardo Barros", "partido_id": 37903, "partido_nome": "Progressistas", "deputado_id": 73788, "despesa_total": "1018487" }, { "id": 73801, "nome": "Renildo Calheiros", "partido_id": 36779, "partido_nome": "Partido Comunista do Brasil", "deputado_id": 73801, "despesa_total": "398056" }, { "id": 73808, "nome": "Sérgio Brito", "partido_id": 36834, "partido_nome": "Partido Social Democrático", "deputado_id": 73808, "despesa_total": "281406" }, { "id": 73943, "nome": "Perpétua Almeida", "partido_id": 36779, "partido_nome": "Partido Comunista do Brasil", "deputado_id": 73943, "despesa_total": "481115" }, { "id": 74043, "nome": "Wellington Roberto", "partido_id": 37906, "partido_nome": "Partido Liberal", "deputado_id": 74043, "despesa_total": "1154695" }, { "id": 74044, "nome": "Wilson Santiago", "partido_id": 37908, "partido_nome": "Republicanos", "deputado_id": 74044, "despesa_total": "414429" }, { "id": 74052, "nome": "Bosco Costa", "partido_id": 37906, "partido_nome": "Partido Liberal", "deputado_id": 74052, "despesa_total": "434699" }, { "id": 74057, "nome": "Alice Portugal", "partido_id": 36779, "partido_nome": "Partido Comunista do Brasil", "deputado_id": 74057, "despesa_total": "275165" }, { "id": 74060, "nome": "Daniel Almeida", "partido_id": 36779, "partido_nome": "Partido Comunista do Brasil", "deputado_id": 74060, "despesa_total": "626817" }, { "id": 74075, "nome": "Elcione Barbalho", "partido_id": 36899, "partido_nome": "Movimento Democrático Brasileiro", "deputado_id": 74075, "despesa_total": "231929" }, { "id": 74079, "nome": "José Priante", "partido_id": 36899, "partido_nome": "Movimento Democrático Brasileiro", "deputado_id": 74079, "despesa_total": "404086" }, { "id": 74090, "nome": "Átila Lins", "partido_id": 36834, "partido_nome": "Partido Social Democrático", "deputado_id": 74090, "despesa_total": "1124345" } ]'
    ];

    public function index(Request $request) {
        try {
            $page = $request->input("pagina", 1);

            // $deputados = (new DeputadoController())->GetDataFromAPI($page)->dados;

            // Somar as despesas individuais de cada um
            // $despesasPorDeputado = DB::select("
            //     select deputados.id, deputados.nome, deputados.partido_id, partidos.id as partido_id, partidos.nome as partido_nome, despesas.deputado_id, SUM(despesas.valor_liquido) as despesa_total
            //     from deputados
            //     left outer join partidos on deputados.partido_id=partidos.id
            //     inner join despesas on deputados.id=despesas.deputado_id
            //     group by despesas.deputado_id, deputados.id, deputados.nome, deputados.partido_id, partidos.id, partidos.nome, despesas.deputado_id
            //     limit 16 offset 16
            // ");

            $links = \App\Utils\Pagination::CalculateLinks($page);

            return view("despesas", [
                "despesasPorDeputado" => $page > 2 ? [] : json_decode($this->fixedReturn[$page-1]),
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
