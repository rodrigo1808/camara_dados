<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PopulateDatabaseWithCamaraData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $BASE_URL;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->BASE_URL = env("API_URL", "https://dadosabertos.camara.leg.br/api/v2");
    }

    public function get($endpoint, $params = null)
    {
        $response = Http::get("{$this->BASE_URL}{$endpoint}");

        return $response['dados'];
    }

    public function removeSingleQuotationMarks($string) 
    {
        return str_replace("'", "", $string);
    }

    public function getLastParamFromUrl($url) {
        $urlParams = explode('/', $url);
        $lastParam = intval(end($urlParams));
        return $lastParam;
    }

    public function insertPartidosData() {
        $partidos = $this->get("/partidos?pagina=1&itens=100");
        $partidosTable = [];

        foreach($partidos as &$partido) {
            $response = $this->get("/partidos/{$partido['id']}");
            \DB::unprepared(
                "INSERT into partidos (id, sigla, url_foto, nome) 
                VALUES ({$response['id']}, '{$response['sigla']}', '{$response['urlLogo']}', '{$response['nome']}')
                ON DUPLICATE KEY UPDATE    
                sigla='{$response['sigla']}', url_foto='{$response['urlLogo']}', nome='{$response['nome']}'"
            );
        }
    }

    public function insertDeputadosData() {
        $deputados = $this->get("/deputados");
        $deputadosTable = [];

        foreach($deputados as &$deputado) {
            $response = $this->get("/deputados/{$deputado['id']}");
            $partidoId = $this->getLastParamFromUrl($response['ultimoStatus']['uriPartido']);

            \DB::unprepared(
                "INSERT into deputados (id, nome, cpf, url_foto, sexo, escolariedade, uf, partido_id, data_nascimento, municipio_nascimento, uf_nascimento, situacao, condicao_eleitoral, email, nome_civil, nome_eleitoral) 
                VALUES ({$response['id']}, 
                        '{$this->removeSingleQuotationMarks($response['ultimoStatus']['nome'])}',
                        '{$response['cpf']}',
                        '{$response['ultimoStatus']['urlFoto']}',
                        '{$response['sexo']}',
                        '{$response['escolaridade']}',
                        '{$response['ultimoStatus']['siglaUf']}',
                        {$partidoId},
                        '{$response['dataNascimento']}',
                        '{$this->removeSingleQuotationMarks($response['municipioNascimento'])}',
                        '{$response['ufNascimento']}',
                        '{$response['ultimoStatus']['situacao']}',
                        '{$response['ultimoStatus']['condicaoEleitoral']}',
                        '{$response['ultimoStatus']['email']}',
                        '{$this->removeSingleQuotationMarks($response['nomeCivil'])}',
                        '{$this->removeSingleQuotationMarks($response['ultimoStatus']['nomeEleitoral'])}')
                ON DUPLICATE KEY UPDATE 
                nome='{$this->removeSingleQuotationMarks($response['ultimoStatus']['nome'])}', 
                cpf='{$response['cpf']}', 
                url_foto='{$response['ultimoStatus']['urlFoto']}', 
                sexo='{$response['sexo']}', 
                escolariedade='{$response['escolaridade']}', 
                uf='{$response['ultimoStatus']['siglaUf']}', 
                partido_id={$partidoId}, 
                data_nascimento='{$response['dataNascimento']}', 
                municipio_nascimento='{$this->removeSingleQuotationMarks($response['municipioNascimento'])}', 
                uf_nascimento='{$response['ufNascimento']}',
                situacao='{$response['ultimoStatus']['situacao']}',
                condicao_eleitoral='{$response['ultimoStatus']['condicaoEleitoral']}',
                email='{$response['ultimoStatus']['email']}',
                nome_civil='{$this->removeSingleQuotationMarks($response['nomeCivil'])}',
                nome_eleitoral='{$this->removeSingleQuotationMarks($response['ultimoStatus']['nomeEleitoral'])}'"
            );
        }
    }

    public function updatePartidosLeader() {
        $partidos = $this->get("/partidos?pagina=1&itens=100");
        $partidosTable = [];

        foreach($partidos as &$partido) {
            $response = $this->get("/partidos/{$partido['id']}");
            $deputadoId = $this->getLastParamFromUrl($response['status']['lider']['uri']);
            $deputado = \DB::select('select * from deputados where id = ?', [$deputadoId]);
            if($deputado) {
                \DB::unprepared(
                    "UPDATE partidos
                    SET lider_id={$deputadoId}
                    WHERE id = {$partido['id']}"
                );
            }
        }
    }

    public function insertDespesasData() {
        $deputados = $this->get("/deputados");
        $deputadosTable = [];  

        foreach([2019,2020,2021,2022] as &$year) {
            foreach($deputados as &$deputado) {
                $despesas = $this->get("/deputados/{$deputado['id']}/despesas?ano={$year}&pagina=1&itens=1000");
                
                foreach($despesas as &$despesa) {
                    $document_number = ($despesa['codDocumento'] == 0) ? $despesa['numDocumento'] : $despesa['codDocumento'];
                    $document_date = empty($despesa['dataDocumento']) ? "{$despesa['ano']}-{$despesa['mes']}-01" : $despesa['dataDocumento'];
                    $net_value = $despesa['valorLiquido'] ? abs(floatval($despesa['valorLiquido'])) : $despesa['valorLiquido'];
                    \DB::unprepared(
                        "INSERT into despesas (numero_documento, data, descricao, valor_liquido, deputado_id) 
                        VALUES ('{$document_number}', '{$document_date}', '{$despesa['tipoDespesa']}', $net_value, {$deputado['id']})
                        ON DUPLICATE KEY UPDATE    
                        data='{$document_date}', descricao='{$despesa['tipoDespesa']}', valor_liquido=$net_value"
                    );
                }
            }
        }
    }

    public function insertOcupacoesData() {
        $deputados = $this->get("/deputados");
        $deputadosTable = [];  

        foreach($deputados as &$deputado) {
            $ocupacoes = $this->get("/deputados/{$deputado['id']}/ocupacoes");
            
            foreach($ocupacoes as &$ocupacao) {
                if($ocupacao['titulo']) {
                    \DB::unprepared(
                        "INSERT into ocupacoes (ocupacao, deputado_id) 
                        VALUES ('{$ocupacao['titulo']} - {$this->removeSingleQuotationMarks($ocupacao['entidade'])}', {$deputado['id']})
                        ON DUPLICATE KEY UPDATE    
                        ocupacao='{$ocupacao['titulo']} - {$this->removeSingleQuotationMarks($ocupacao['entidade'])}'"
                    );
                }
            }
        }
    }

    public function insertFrentesData() {
        $frentes = $this->get("/frentes?idLegislatura=56");
        $frentesTable = [];  

        foreach($frentes as &$frente) {
            $frente = $this->get("/frentes/{$frente['id']}");
            $deputado = \DB::select('select * from deputados where id = ?', [$frente['coordenador']['id']]);
            if($deputado) {
                \DB::unprepared(
                    "INSERT into frentes (id, titulo, telefone, coordenador_id) 
                    VALUES ({$frente['id']}, '{$this->removeSingleQuotationMarks($frente['titulo'])}', '{$frente['telefone']}', {$frente['coordenador']['id']})
                    ON DUPLICATE KEY UPDATE    
                    titulo='{$this->removeSingleQuotationMarks($frente['titulo'])}', telefone='{$frente['telefone']}' , coordenador_id={$frente['coordenador']['id']}"
                );
            }
        }
    }

    public function insertDeputadosFrentesRelationData() {
        $deputados = $this->get("/deputados");
        $deputadosTable = [];  

        foreach($deputados as &$deputado) {
            $frentesRelation = $this->get("/deputados/{$deputado['id']}/frentes");
            
            foreach($frentesRelation as &$relation) {
                $frente = \DB::select('select * from frentes where id = ?', [$relation['id']]);
                if($relation['idLegislatura'] == 56 && $frente) {
                    \DB::unprepared(
                        "INSERT into deputados_frentes (deputado_id, frente_id) 
                        VALUES ({$deputado['id']}, {$relation['id']})
                        ON DUPLICATE KEY UPDATE    
                        deputado_id={$deputado['id']}, frente_id={$relation['id']}"
                    );
                }
            }
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->insertPartidosData();
        $this->insertDeputadosData();
        $this->updatePartidosLeader();
        $this->insertDespesasData();
        $this->insertOcupacoesData();
        $this->insertFrentesData();
        $this->insertDeputadosFrentesRelationData();
    }
}
