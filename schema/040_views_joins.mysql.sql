-- Auto-generated from joins-mysql.yaml (map@94ebe6c)
-- engine: mysql
-- view:   order_items_detailed

CREATE OR REPLACE ALGORITHM=TEMPTABLE SQL SECURITY INVOKER VIEW vw_order_items_detailed AS
SELECT
  oi.id,
  oi.order_id,
  oi.tenant_id,
  oi.book_id,
  oi.title_snapshot    AS item_title,
  oi.sku_snapshot      AS item_sku,
  oi.quantity,
  oi.unit_price,
  oi.currency,
  oi.tax_rate,
  o.user_id,
  o.status             AS order_status,
  b.title              AS book_title,
  a.name               AS author_name,
  c.name               AS category_name
FROM order_items oi
LEFT JOIN orders o
  ON o.tenant_id = oi.tenant_id AND o.id = oi.order_id
LEFT JOIN books b
  ON b.tenant_id = oi.tenant_id AND b.id = oi.book_id
LEFT JOIN authors a
  ON a.tenant_id = b.tenant_id AND a.id = b.author_id
LEFT JOIN categories c
  ON c.tenant_id = b.tenant_id AND c.id = b.main_category_id;
