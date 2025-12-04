-- Auto-generated from schema-views-mysql.yaml (map@74ce4f4)
-- engine: mysql
-- table:  order_items

-- Contract view for [order_items]
CREATE OR REPLACE ALGORITHM=MERGE SQL SECURITY INVOKER VIEW vw_order_items AS
SELECT
  id,
  tenant_id,
  order_id,
  book_id,
  product_ref,
  title_snapshot,
  sku_snapshot,
  unit_price,
  quantity,
  tax_rate,
  currency,
  created_at,
  updated_at
FROM order_items;
