<?php
declare(strict_types=1);

namespace BlackCat\Database\Packages\OrderItems\Dto;

/**
 * Jednoduché, neměnné DTO s veřejnými readonly vlastnostmi.
 * - Žádná logika; pouze nosič dat.
 * - Silné typy drží kontrakt napříč vrstvami.
 */
final class OrderItemDto {
    public function __construct(
        public readonly ?int $id,
        public readonly ?int $orderId,
        public readonly ?int $bookId,
        public readonly ?int $productRef,
        public readonly string $titleSnapshot,
        public readonly ?string $skuSnapshot,
        public readonly string $unitPrice,
        public readonly int $quantity,
        public readonly string $taxRate,
        public readonly string $currency
    ) {}

    /** Vhodné pro serializaci/logování (bez binárních/velkých blobů). */
    public function toArray(): array {
        // get_object_vars funguje dobře s public readonly vlastnostmi
        return get_object_vars($this);
    }
}
