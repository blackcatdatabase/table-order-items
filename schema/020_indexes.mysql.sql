-- Auto-generated from schema-map-mysql.yaml (map@sha1:B9D3BE28A74392B9B389FDAFB493BD80FA1F6FA4)
-- engine: mysql
-- table:  order_items

CREATE UNIQUE INDEX ux_order_items_tenant_id ON order_items (tenant_id, id);
