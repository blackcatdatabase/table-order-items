-- Auto-generated from schema-views-postgres.psd1 (map@mtime:2025-10-24T09:45:40Z)
-- engine: postgres
-- table:  order_items
-- Contract view for [order_items]
CREATE OR REPLACE VIEW vw_order_items AS
SELECT
  id,
  order_id,
  book_id,
  product_ref,
  title_snapshot,
  sku_snapshot,
  unit_price,
  quantity,
  tax_rate,
  currency
FROM order_items;
