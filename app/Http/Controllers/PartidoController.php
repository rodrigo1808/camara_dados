<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartidoController extends Controller
{
    protected int $itensPerPage = 16;
    protected $fixedReturn = [
        '[{ "nome": "Avante", "sigla": "AVANTE", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/AVANTE.gif", "despesa_total": "1709162", "quantidade_membros": 6 }, { "nome": "Cidadania", "sigla": "CIDADANIA", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/CIDADANIA.gif", "despesa_total": "1469709", "quantidade_membros": 6 }, { "nome": "Movimento Democrático Brasileiro", "sigla": "MDB", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/MDB.gif", "despesa_total": "17315868", "quantidade_membros": 36 }, { "nome": "Partido Comunista do Brasil", "sigla": "PCdoB", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PCdoB.gif", "despesa_total": "4753224", "quantidade_membros": 8 }, { "nome": "Partido da Social Democracia Brasileira", "sigla": "PSDB", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PSDB.gif", "despesa_total": "11672374", "quantidade_membros": 21 }, { "nome": "Partido Democrático Trabalhista", "sigla": "PDT", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PDT.gif", "despesa_total": "8453328", "quantidade_membros": 19 }, { "nome": "Partido dos Trabalhadores", "sigla": "PT", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PT.gif", "despesa_total": "27314765", "quantidade_membros": 56 }, { "nome": "Partido Liberal", "sigla": "PL", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PL.gif", "despesa_total": "33881257", "quantidade_membros": 77 }, { "nome": "Partido Novo", "sigla": "NOVO", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/NOVO.gif", "despesa_total": "1815335", "quantidade_membros": 8 }, { "nome": "Partido Republicano da Ordem Social", "sigla": "PROS", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PROS.gif", "despesa_total": "2419478", "quantidade_membros": 4 }, { "nome": "Partido Social Cristão", "sigla": "PSC", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PSC.gif", "despesa_total": "4403798", "quantidade_membros": 8 }, { "nome": "Partido Social Democrático", "sigla": "PSD", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PSD.gif", "despesa_total": "20139759", "quantidade_membros": 47 }, { "nome": "Partido Socialismo e Liberdade", "sigla": "PSOL", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PSOL.gif", "despesa_total": "4110701", "quantidade_membros": 8 }, { "nome": "Partido Socialista Brasileiro", "sigla": "PSB", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PSB.gif", "despesa_total": "6850413", "quantidade_membros": 24 }, { "nome": "Partido Trabalhista Brasileiro", "sigla": "PTB", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PTB.gif", "despesa_total": "1739847", "quantidade_membros": 3 }, { "nome": "Partido Verde", "sigla": "PV", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PV.gif", "despesa_total": "2221311", "quantidade_membros": 4 } ]',
        '[ { "nome": "Patriota", "sigla": "PATRIOTA", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PATRIOTA.gif", "despesa_total": "3946968", "quantidade_membros": 5 }, { "nome": "Podemos", "sigla": "PODE", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PODE.gif", "despesa_total": "2283231", "quantidade_membros": 8 }, { "nome": "Progressistas", "sigla": "PP", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/PP.gif", "despesa_total": "23904558", "quantidade_membros": 56 }, { "nome": "Rede Sustentabilidade", "sigla": "REDE", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/REDE.gif", "despesa_total": "1095521", "quantidade_membros": 2 }, { "nome": "Republicanos", "sigla": "REPUBLICANOS", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/REPUBLICANOS.gif", "despesa_total": "24961691", "quantidade_membros": 42 }, { "nome": "Solidariedade", "sigla": "SOLIDARIEDADE", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/SOLIDARIEDADE.gif", "despesa_total": "4358767", "quantidade_membros": 8 }, { "nome": "União Brasil", "sigla": "UNIÃO", "url_foto": "http://www.camara.leg.br/internet/Deputado/img/partidos/UNIÃO.gif", "despesa_total": "24009897", "quantidade_membros": 53 } ]'
    ];

    public function index(Request $request) {
        $page = $request->query("pagina", 1);

        /*$body = DB::select("
            select partidos.nome, partidos.sigla, partidos.url_foto, sum(despesas.valor_liquido) as despesa_total, count(distinct deputados.id) as quantidade_membros 
            from partidos
            inner join deputados on partidos.id=deputados.partido_id
            inner join despesas on deputados.id=despesas.deputado_id
            group by partidos.nome, partidos.sigla, partidos.url_foto
            limit 16 offset 16
        ");*/

        $links = \App\Utils\Pagination::CalculateLinks($page);

        return view("partidos", [
            "partidos" => $page > 2 ? [] : json_decode($this->fixedReturn[$page-1]),
            "links" => $links
        ]);
    }
}
