<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\OrderItems;

final class Definitions {
    // --- základní metadata ---
    public static function table(): string { return 'order_items'; }
    public static function contractView(): string { return 'vw_order_items'; }
    /** @return string[] */
    public static function columns(): array { return [ 'id', 'order_id', 'book_id', 'product_ref', 'title_snapshot', 'sku_snapshot', 'unit_price', 'quantity', 'tax_rate', 'currency' ]; }
    public static function pk(): string { return 'id'; }

    // --- volitelná metadata (mohou být prázdná) ---
    public static function softDeleteColumn(): ?string {
        $c = ''; return $c !== '' ? $c : null;
    }
    public static function updatedAtColumn(): ?string {
        $c = ''; return $c !== '' ? $c : null;
    }
    public static function versionColumn(): ?string {
        $c = ''; return $c !== '' ? $c : null; // pro optimistic locking
    }
    /** např. "created_at DESC, id DESC" */
    public static function defaultOrder(): ?string {
        $c = 'id DESC'; return $c !== '' ? $c : null;
    }
    /** @return array<int,array<int,string>> seznam unikátních klíčů (sloupcových kombinací) */
    public static function uniqueKeys(): array { return []; }
    /** @return string[] JSON sloupce kvůli castům/operacím */
    public static function jsonColumns(): array { return []; }

    // --- pomocníci ---
    public static function hasColumn(string $col): bool {
        static $set = null;
        if ($set === null) { $set = array_fill_keys(self::columns(), true); }
        return isset($set[$col]);
    }
}
