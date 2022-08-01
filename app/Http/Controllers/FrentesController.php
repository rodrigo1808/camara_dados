<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FrentesController extends Controller
{
    protected int $itensPerPage = 16;
    protected $fixedReturn = [
        '[ { "titulo": "Frente Parlamentar Ambientalista", "telefone": "3215 5304", "coordenador_nome": "Alessandro Molon", "quantidade_membros": 200, "despesa_total": 103334734}, { "titulo": "Frente Parlamentar Armamentista - FPAR", "telefone": "3215 5380", "coordenador_nome": "Loester Trutis", "quantidade_membros": 190, "despesa_total": 88747260}, { "titulo": "Frente Parlamentar Brasil Japão", "telefone": "3215 5907", "coordenador_nome": "Luiz Nishimori", "quantidade_membros": 187, "despesa_total": 98257180}, { "titulo": "Frente Parlamentar Brasil-China", "telefone": "3215 5562", "coordenador_nome": "Fausto Pinato", "quantidade_membros": 204, "despesa_total": 103559667}, { "titulo": "Frente Parlamentar Brasil-Coreia do Sul", "telefone": "3215 5630", "coordenador_nome": "Claudio Cajado", "quantidade_membros": 199, "despesa_total": 94111494}, { "titulo": "Frente Parlamentar BRASIL-EUA", "telefone": "3215 5628", "coordenador_nome": "Eduardo da Fonte", "quantidade_membros": 241, "despesa_total": 115772451}, { "titulo": "Frente Parlamentar Brasil-Rússia", "telefone": "3215 5741", "coordenador_nome": "David Soares", "quantidade_membros": 205, "despesa_total": 94403979}, { "titulo": "Frente Parlamentar com Participação Popular Feminista e Antirracista", "telefone": "3215 5623", "coordenador_nome": "Talíria Petrone", "quantidade_membros": 194, "despesa_total": 98432083}, { "titulo": "Frente Parlamentar Contra o Abuso e Exploração Sexual de Crianças e Adolescentes", "telefone": "3215 5946", "coordenador_nome": "Roberto Alves", "quantidade_membros": 180, "despesa_total": 91359424}, { "titulo": "Frente Parlamentar da Advocacia", "telefone": "3215 5452", "coordenador_nome": "Fábio Trad", "quantidade_membros": 185, "despesa_total": 85534150}, { "titulo": "Frente Parlamentar da Agropecuária - FPA", "telefone": "3215 5238", "coordenador_nome": "Sergio Souza", "quantidade_membros": 230, "despesa_total": 115948465}, { "titulo": "Frente Parlamentar da Baixada Fluminense do Rio de Janeiro", "telefone": "3215 5641", "coordenador_nome": "Juninho do Pneu", "quantidade_membros": 197, "despesa_total": 96210868}, { "titulo": "Frente Parlamentar da Câmara dos Deputados Brasil - Bolívia.", "telefone": "3215 5458", "coordenador_nome": "Coronel Chrisóstomo", "quantidade_membros": 191, "despesa_total": 92279750}, { "titulo": "Frente Parlamentar da Habitação e Desenvolvimento Urbano do Congresso Nacional", "telefone": "3215 5634", "coordenador_nome": "Ricardo Izar", "quantidade_membros": 192, "despesa_total": 97616388}, { "titulo": "Frente Parlamentar da Indústria de Máquinas e Equipamentos - FPMaq", "telefone": "3215 5823", "coordenador_nome": "Vitor Lippi", "quantidade_membros": 200, "despesa_total": 90152648}, { "titulo": "Frente Parlamentar da Indústria Pública de Medicamentos", "telefone": "3215 5412", "coordenador_nome": "Ricardo Barros", "quantidade_membros": 196, "despesa_total": 94895553 } ]'
    ];

    public function index(Request $request) {
        $page = $request->query("pagina", 1);
        
        // $body = [];
        // $cacheKey = "membro_despesas_por_frente-pagina-" . $page;
        // if (false) {
        //     $body = Cache::get($cacheKey);
        // } else {
        //     $body = DB::select("
        //         select frentes.titulo, frentes.telefone, coordenador.nome as coordenador_nome, count(distinct deputados_frentes.deputado_id) as quantidade_membros, sum(despesas.valor_liquido) as despesa_total
        //         from frentes
        //         inner join deputados as coordenador on frentes.coordenador_id=coordenador.id
        //         left outer join deputados_frentes on frentes.id=deputados_frentes.frente_id
        //         left outer join despesas on deputados_frentes.deputado_id=despesas.deputado_id
        //         group by frentes.titulo, frentes.telefone, coordenador.nome
        //         limit 16 offset 0
        //     ");

        //     Cache::put($cacheKey, $body);
        // }
        $links = \App\Utils\Pagination::CalculateLinks($page);

        return view("frentes", [
            "frentes" => json_decode($this->fixedReturn[0]),
            "links" => $links
        ]);
    }
}
