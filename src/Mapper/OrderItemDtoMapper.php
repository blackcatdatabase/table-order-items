<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\OrderItems\Mapper;

use BlackCat\Database\Packages\OrderItems\Dto\OrderItemDto;
use BlackCat\Database\Packages\OrderItems\Definitions;
use DateTimeZone;
use BlackCat\Database\Support\DtoHydrator;

/**
 * Bidirectional mapper between DB rows and DTO OrderItemDto:
 * - Casting/JSON/binary/datetime handled by the universal DtoHydrator
 * - Column -> property mapping is driven by COL_TO_PROP (populated by the generator)
 * - Tolerant to missing columns (keeps null)
 */
final class OrderItemDtoMapper
{
    /** @var array<string,string> Column -> DTO property */
    private const COL_TO_PROP = [ 'id' => 'id', 'tenant_id' => 'tenantId', 'order_id' => 'orderId', 'book_id' => 'bookId', 'product_ref' => 'productRef', 'title_snapshot' => 'titleSnapshot', 'sku_snapshot' => 'skuSnapshot', 'unit_price' => 'unitPrice', 'quantity' => 'quantity', 'tax_rate' => 'taxRate', 'currency' => 'currency' ];

    /** @var string[] */
    private const BOOL_COLS   = [];
    /** @var string[] */
    private const INT_COLS    = [ 'id', 'tenant_id', 'order_id', 'book_id', 'product_ref', 'quantity' ];
    /** @var string[] */
    private const FLOAT_COLS  = [ 'unit_price', 'tax_rate' ];
    /** @var string[] */
    private const JSON_COLS   = [];
    /** @var string[] */
    private const DATE_COLS   = [];
    /** @var string[] */
    private const BIN_COLS    = [];

    /** Preferred timezone for parsing/serializing dates */
    private const TZ = 'UTC';

    private static ?DateTimeZone $tzObj = null;

    private static function tz(): DateTimeZone
    {
        if (!(self::$tzObj instanceof DateTimeZone)) {
            self::$tzObj = new DateTimeZone(self::TZ);
        }
        return self::$tzObj;
    }

    /**
     * Hydrate a DTO from a DB row (associative array).
     *
     * @param array<string,mixed> $row
     * @return OrderItemDto
     */
    public static function fromRow(array $row): OrderItemDto
    {
        /** @var OrderItemDto */
        return DtoHydrator::fromRow(
            OrderItemDto::class,
            $row,
            self::COL_TO_PROP,
            self::BOOL_COLS,
            self::INT_COLS,
            self::FLOAT_COLS,
            self::JSON_COLS,
            self::DATE_COLS,
            self::BIN_COLS,
            self::tz()
        );
    }

    public static function fromRowOrNull(?array $row): ?OrderItemDto
    {
        return $row === null ? null : self::fromRow($row);
    }

    /**
     * Serialize a DTO back into a DB row (for insert/update).
     * - JSON -> string, DATETIME -> 'Y-m-d H:i:s.u', BOOL -> 0/1, BINARY -> raw bytes
     *
     * @param OrderItemDto   $dto
     * @param string[]|null   $onlyProps  optional whitelist of DTO properties to serialize
     * @return array<string,mixed>
     */
    public static function toRow(OrderItemDto $dto, ?array $onlyProps = null): array
    {
        return DtoHydrator::toRow(
            $dto,
            self::COL_TO_PROP,
            self::BOOL_COLS,
            self::INT_COLS,
            self::FLOAT_COLS,
            self::JSON_COLS,
            self::DATE_COLS,
            self::BIN_COLS,
            self::tz(),
            $onlyProps
        );
    }

    /** Same as toRow(), but removes keys with null values (does not overwrite DB values with NULL). */
    public static function toRowNonNull(OrderItemDto $dto, ?array $onlyProps = null): array
    {
        $row = self::toRow($dto, $onlyProps);
        foreach ($row as $k => $v) {
            if ($v === null) unset($row[$k]);
        }
        return $row;
    }

    /**
     * Compute changed columns relative to the original row (assoc array from DB).
     * Returns only differing pairs col => newValue.
     *
     * @param array<string,mixed> $original
     * @param string[] $ignore   Columns to skip during comparison (e.g., updated_at)
     * @param bool $coerce       Normalize scalars (0 vs '0', true vs 1) before comparing
     * @return array<string,mixed>
     */
    public static function diff(OrderItemDto $dto, array $original, array $ignore = [], bool $coerce = true): array
    {
        $now = self::toRow($dto);

        if ($ignore) {
            $drop = array_fill_keys($ignore, true);
            $now = array_filter($now, static fn($k) => !isset($drop[$k]), ARRAY_FILTER_USE_KEY);
        }

        $out = [];
        foreach ($now as $k => $v) {
            $orig = $original[$k] ?? null;

            if ($coerce && is_scalar($v) && is_scalar($orig)) {
                $vn = is_bool($v) ? (int)$v : (string)$v;
                $on = is_bool($orig) ? (int)$orig : (string)$orig;
                if ($vn === $on) continue;
            } elseif ($v == $orig) { // looser comparison for nested structures
                continue;
            }

            $out[$k] = $v;
        }
        return $out;
    }

    /**
     * Batch hydration: array of rows -> array of DTOs.
     *
     * @param array<int,array<string,mixed>> $rows
     * @return array<int,OrderItemDto>
     */
    public static function hydrateList(array $rows): array
    {
        /** @var array<int,OrderItemDto> */
        return DtoHydrator::hydrateList(
            OrderItemDto::class,
            $rows,
            self::COL_TO_PROP,
            self::BOOL_COLS,
            self::INT_COLS,
            self::FLOAT_COLS,
            self::JSON_COLS,
            self::DATE_COLS,
            self::BIN_COLS,
            self::tz()
        );
    }

    /** @return array<string,mixed> */
    public static function toSafeArray(OrderItemDto $dto): array
    {
        $row = self::toRow($dto);

        $pii = [];
        if (\method_exists(Definitions::class, 'piiColumns')) {
            $decl = (array) Definitions::piiColumns();

            if ($decl) {
                $map = self::COL_TO_PROP;         // col -> prop
                $rev = array_flip($map);          // prop -> col

                foreach ($decl as $name) {
                    $name = (string) $name;
                    // accept both 'email' (column) and 'emailHash' (property)
                    $col = array_key_exists($name, $row) ? $name : ($rev[$name] ?? $name);
                    $pii[$col] = true;
                }
            }
        }

        if ($pii) {
            foreach ($row as $k => &$v) {
                if (isset($pii[$k]) && $v !== null && $v !== '') {
                    $v = '***';
                }
            }
            unset($v);
        }

        return $row;
    }

    /**
     * Lazy hydration - generates DTOs without buffering the entire collection.
     * @param iterable<int,array<string,mixed>> $rows
     * @return \Generator<int,OrderItemDto>
     */
    public static function hydrate(iterable $rows): \Generator
    {
        foreach ($rows as $row) {
            yield self::fromRow($row);
        }
    }
}
