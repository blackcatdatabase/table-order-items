-- Auto-generated from schema-map-postgres.yaml (map@74ce4f4)
-- engine: postgres
-- table:  order_items

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE RESTRICT;

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_order FOREIGN KEY (tenant_id, order_id) REFERENCES orders(tenant_id, id) ON DELETE CASCADE;

ALTER TABLE order_items ADD  CONSTRAINT fk_order_items_book  FOREIGN KEY (tenant_id, book_id) REFERENCES books(tenant_id, id) ON DELETE SET NULL;
