-- Auto-generated from schema-map-mysql.yaml (map@sha1:09DF9CA612D1573E058190CC207FA257C05AEC1F)
-- engine: mysql
-- table:  order_items

CREATE UNIQUE INDEX ux_order_items_tenant_id ON order_items (tenant_id, id);
