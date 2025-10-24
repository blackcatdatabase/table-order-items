-- Auto-generated from schema-map-postgres.psd1 (map@mtime:2025-10-24T09:46:38Z)
-- engine: postgres
-- table:  order_items
CREATE INDEX idx_order_items_order_id ON order_items (order_id);

CREATE INDEX idx_order_items_book_id ON order_items (book_id);
