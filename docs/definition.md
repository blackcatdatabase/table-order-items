<!-- Auto-generated from schema-map.psd1 @ 1e83bb6 (2025-10-21T10:18:36+02:00) -->
# Definition – order_items

Normalized order line items (snapshotted data).

## Columns
| Column | Type | Null | Default | Description | Notes |
|-------:|:-----|:----:|:--------|:------------|:------|
| id | BIGINT UNSIGNED | — | — | Surrogate primary key. |  |
| order_id | BIGINT UNSIGNED | YES | — | Order (FK orders.id). |  |
| book_id | BIGINT UNSIGNED | YES | — | Book (FK books.id), optional for non-book items. |  |
| product_ref | INT | YES | — | External product reference (optional). |  |
| title_snapshot | VARCHAR(255) | NO | — | Captured title at purchase time. |  |
| sku_snapshot | VARCHAR(64) | YES | — | Captured SKU at purchase time. |  |
| unit_price | DECIMAL(12,2) | NO | — | Unit price at purchase. |  |
| quantity | INT UNSIGNED | NO | — | Quantity (> 0). |  |
| tax_rate | DECIMAL(5,2) | NO | — | Tax rate %. |  |
| currency | CHAR(3) | NO | — | ISO 4217 currency code. |  |
