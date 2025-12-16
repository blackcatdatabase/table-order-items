-- Auto-generated from schema-map-mysql.yaml (map@sha1:B9D3BE28A74392B9B389FDAFB493BD80FA1F6FA4)
-- engine: mysql
-- table:  order_items

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_tenant FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_order FOREIGN KEY (tenant_id, order_id) REFERENCES orders(tenant_id, id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_book FOREIGN KEY (tenant_id, book_id) REFERENCES books(tenant_id, id) ON DELETE CASCADE ON UPDATE RESTRICT;

ALTER TABLE order_items ADD CONSTRAINT chk_order_items_tax_rate CHECK (tax_rate BETWEEN 0 AND 100);
