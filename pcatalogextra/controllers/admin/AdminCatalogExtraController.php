<?php
// modules/pcatalogextra/controllers/admin/AdminCatalogExtraController.php
class AdminCatalogExtraController extends ModuleAdminController
{
    private static $hasShopCol = null; // cache por proceso

    public function ajaxProcessGetAvailableDates()
    {
        header('Content-Type: application/json; charset=utf-8');

        // Acepta POST o GET
        $idsRaw = (string)Tools::getValue('ids', '');
        if ($idsRaw === '' && !empty($_POST['ids'])) {
            $idsRaw = (string)$_POST['ids'];
        }

        $ids = array_values(array_unique(array_filter(array_map('intval', explode(',', $idsRaw)))));
        if (empty($ids)) {
            die(json_encode(['ok' => true, 'data' => new stdClass()]));
        }

        // límite prudente
        if (count($ids) > 400) {
            $ids = array_slice($ids, 0, 400);
        }

        try {
            $db = Db::getInstance();
            $idShop = (int)$this->context->shop->id;
            $in = implode(',', array_map('intval', $ids));

            if (self::$hasShopCol === null) {
                // cachea la detección para este proceso PHP
                try {
                    self::$hasShopCol = !empty($db->executeS('SHOW COLUMNS FROM `'._DB_PREFIX_.'product_shop` LIKE "available_date"'));
                } catch (Exception $e) {
                    self::$hasShopCol = false;
                }
            }

            if (self::$hasShopCol) {
                $sql = '
                    SELECT p.id_product,
                           COALESCE(NULLIF(ps.available_date,"0000-00-00"),
                                    NULLIF(p.available_date,"0000-00-00")) AS d,
                           p.date_add
                    FROM `'._DB_PREFIX_.'product` p
                    LEFT JOIN `'._DB_PREFIX_.'product_shop` ps
                      ON ps.id_product=p.id_product AND ps.id_shop='.$idShop.'
                    WHERE p.id_product IN ('.$in.')
                ';
            } else {
                $sql = '
                    SELECT p.id_product,
                           NULLIF(p.available_date,"0000-00-00") AS d,
                           p.date_add
                    FROM `'._DB_PREFIX_.'product` p
                    WHERE p.id_product IN ('.$in.')
                ';
            }

            $rows = $db->executeS($sql);
            if ($rows === false) {
                $msg = method_exists($db,'getMsgError') ? $db->getMsgError() : 'query failed';
                die(json_encode(['ok' => false, 'error' => $msg]));
            }

            $out = [];
            foreach ($ids as $id) $out[(string)$id] = '';
            foreach ($rows as $r) {
                $date = '';
                if (!empty($r['d'])) {
                    $date = substr($r['d'], 0, 10);
                } elseif (!empty($r['date_add']) && $r['date_add'] !== '0000-00-00 00:00:00') {
                    $date = substr($r['date_add'], 0, 10); // fallback visual
                }
                $out[(string)$r['id_product']] = $date;
            }

            die(json_encode(['ok' => true, 'data' => $out]));
        } catch (Exception $e) {
            PrestaShopLogger::addLog('[pcatalogextra] getAvailableDates error: '.$e->getMessage(), 3, 0, 'AdminCatalogExtra', 0, true);
            die(json_encode(['ok' => false, 'error' => 'server error']));
        }
    }
}
