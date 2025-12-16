-- Auto-generated from schema-map-postgres.yaml (map@sha1:FAEA49A5D5F8FAAD9F850D0F430ED451C5C1D707)
-- engine: postgres
-- table:  order_items

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_order  FOREIGN KEY (tenant_id, order_id) REFERENCES orders(tenant_id, id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_book   FOREIGN KEY (tenant_id, book_id) REFERENCES books(tenant_id, id) ON DELETE CASCADE ON UPDATE RESTRICT;
