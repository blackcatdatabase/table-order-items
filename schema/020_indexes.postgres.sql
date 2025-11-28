-- Auto-generated from schema-map-postgres.psd1 (map@mtime:2025-11-21T00:25:46Z)
-- engine: postgres
-- table:  order_items

CREATE INDEX IF NOT EXISTS idx_order_items_order_id ON order_items (order_id);

CREATE INDEX IF NOT EXISTS idx_order_items_book_id ON order_items (book_id);

CREATE INDEX IF NOT EXISTS idx_order_items_tenant_order ON order_items (tenant_id, order_id);

CREATE INDEX IF NOT EXISTS idx_order_items_tenant_book  ON order_items (tenant_id, book_id);
