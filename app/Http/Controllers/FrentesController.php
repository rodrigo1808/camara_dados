<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FrentesController extends Controller
{
    protected int $itensPerPage = 16;

    public function index(Request $request) {
        $page = $request->query("pagina", 1);

        $body = [];
        $cacheKey = "membro_despesas_por_frente-pagina-" . $page;
        if (Cache::has($cacheKey)) {
            $body = Cache::get($cacheKey);
        } else {
            $body = DB::select("
                select frentes.titulo, frentes.telefone, coordenador.nome as coordenador_nome, count(deputados_frentes.frente_id) as quantidade_membros, sum(despesas.valor_liquido) as despesa_total
                from frentes
                inner join deputados as coordenador on frentes.coordenador_id=coordenador.id
                left outer join deputados_frentes on frentes.id=deputados_frentes.frente_id
                left outer join despesas on deputados_frentes.deputado_id=despesas.deputado_id
                group by frentes.titulo, frentes.telefone, coordenador.nome
                limit ? offset ?
            ", [$this->itensPerPage, $this->itensPerPage * ($page - 1)]);

            Cache::put($cacheKey, $body);
        }

        return view("frentes", [
            "frentes" => $body
        ]);
    }
}
