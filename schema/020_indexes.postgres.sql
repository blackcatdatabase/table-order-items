-- Auto-generated from schema-map-postgres.yaml (map@sha1:FAEA49A5D5F8FAAD9F850D0F430ED451C5C1D707)
-- engine: postgres
-- table:  order_items

CREATE INDEX IF NOT EXISTS idx_order_items_order_id ON order_items (order_id);

CREATE INDEX IF NOT EXISTS idx_order_items_book_id ON order_items (book_id);

CREATE INDEX IF NOT EXISTS idx_order_items_tenant_order ON order_items (tenant_id, order_id);

CREATE INDEX IF NOT EXISTS idx_order_items_tenant_book  ON order_items (tenant_id, book_id);

CREATE UNIQUE INDEX IF NOT EXISTS ux_order_items_tenant_id ON order_items (tenant_id, id);
