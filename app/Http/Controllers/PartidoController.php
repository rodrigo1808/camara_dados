<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartidoController extends Controller
{
    protected int $itensPerPage = 16;

    public function index(Request $request) {
        $page = $request->query("pagina", 1);

        $body = DB::select("
            select partidos.nome, partidos.sigla, partidos.url_foto, sum(despesas.valor_liquido) as despesa_total, count(distinct deputados.id) as quantidade_membros 
            from partidos
            inner join deputados on partidos.id=deputados.partido_id
            inner join despesas on deputados.id=despesas.deputado_id
            group by partidos.nome, partidos.sigla, partidos.url_foto
            limit ? offset ?
        ", [$this->itensPerPage, $this->itensPerPage * ($page - 1)]);

        $links = \App\Utils\Pagination::CalculateLinks($page);

        return view("partidos", [
            "partidos" => $body,
            "links" => $links
        ]);
    }
}
