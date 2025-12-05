-- Auto-generated from schema-map-mysql.yaml (map@74ce4f4)
-- engine: mysql
-- table:  order_items

CREATE UNIQUE INDEX ux_order_items_tenant_id ON order_items (tenant_id, id);
