-- Auto-generated from schema-map-mysql.yaml (map@sha1:5E62933580349BE7C623D119AC9D1301A62F03EF)
-- engine: mysql
-- table:  order_items

CREATE UNIQUE INDEX ux_order_items_tenant_id ON order_items (tenant_id, id);
