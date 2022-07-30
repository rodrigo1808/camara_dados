<?php

namespace App\Utils;

use stdClass;

class Pagination {
    protected static int $firstItem = -3;
    protected static int $lastItem = 5;

    static public function CalculateLinks(int $currentPage): array {
        $result = [];

        for ($i = self::$firstItem; $i <= self::$lastItem; $i++) { 
            $relativePage = $i + $currentPage;
            $link = new stdClass();

            if ($relativePage <= 0)
                continue;

            if ($i == self::$firstItem) {
                // Adicionar pagina anterior
                /* $result[] = [
                    "label" => "Anterior",
                    "pagina" => $currentPage - 1,
                    "rel" => "anterior"
                ]; */
                $link->label = "Anterior";
                $link->pagina = $currentPage - 1;
                $link->rel = "anterior";
                $result[] = $link;

                continue;
            }

            if ($i == self::$lastItem) {
                // Como saber se é a última página?
                /* $result[] = [
                    "label" => "Proximo",
                    "pagina" => $currentPage + 1,
                    "rel" => "proximo"
                ]; */
                $link->label = "Proximo";
                $link->pagina = $currentPage + 1;
                $link->rel = "proximo";
                $result[] = $link;

                continue;
            }

            /* $result[] = [
                "label" => $relativePage,
                "pagina" => $relativePage,
                "rel" => $relativePage == $currentPage ? "atual" : "",
            ]; */
            $link->label = $relativePage;
            $link->pagina = $relativePage;
            $link->rel = $relativePage == $currentPage ? "atual" : "";
            $result[] = $link;
        }

        return $result;
    }
}