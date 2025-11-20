<!-- Auto-generated from schema-map-postgres.psd1 @ 62c9c93 (2025-11-20T21:38:11+01:00) -->
# Definition – order_items

Normalized order line items (snapshotted data).

## Columns
| Column | Type | Null | Default | Description | Notes |
|-------:|:-----|:----:|:--------|:------------|:------|
| id | BIGINT | — | AS | Surrogate primary key. |  |
| tenant_id | BIGINT | NO | — |  |  |
| order_id | BIGINT | YES | — | Order (FK orders.id). |  |
| book_id | BIGINT | YES | — | Book (FK books.id), optional for non-book items. |  |
| product_ref | INTEGER | YES | — | External product reference (optional). |  |
| title_snapshot | VARCHAR(255) | NO | — | Captured title at purchase time. |  |
| sku_snapshot | VARCHAR(64) | YES | — | Captured SKU at purchase time. |  |
| unit_price | NUMERIC(12,2) | NO | — | Unit price at purchase. |  |
| quantity | INTEGER | NO | — | Quantity (> 0). |  |
| tax_rate | NUMERIC(5,2) | NO | — | Tax rate % (0..100). |  |
| currency | CHAR(3) | NO | — | ISO 4217 currency code. |  |