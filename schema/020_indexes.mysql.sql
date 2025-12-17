-- Auto-generated from schema-map-mysql.yaml (map@sha1:7AAC4013A2623AC60C658C9BF8458EFE0C7AB741)
-- engine: mysql
-- table:  order_items

CREATE UNIQUE INDEX ux_order_items_tenant_id ON order_items (tenant_id, id);
