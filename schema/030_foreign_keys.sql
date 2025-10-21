-- Auto-generated from schema-map.psd1 on 2025-10-21T02:32:05
-- table: order_items
ALTER TABLE order_items ADD CONSTRAINT fk_order_items_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE;

ALTER TABLE order_items ADD CONSTRAINT fk_order_items_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE SET NULL;
