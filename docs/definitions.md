# order_items

Normalized order line items (snapshotted data).

## Columns
| Column | Type | Null | Default | Description | Crypto |
| --- | --- | --- | --- | --- | --- |
| id | BIGINT | NO |  | Surrogate primary key. |  |
| tenant_id | BIGINT | NO |  | Owning tenant (FK tenants.id). |  |
| order_id | BIGINT | YES |  | Order (FK orders.id). |  |
| book_id | BIGINT | YES |  | Book (FK books.id), optional for non-book items. |  |
| product_ref | mysql: INT / postgres: INTEGER | YES |  | External product reference (optional). |  |
| title_snapshot | VARCHAR(255) | NO |  | Captured title at purchase time. |  |
| sku_snapshot | VARCHAR(64) | YES |  | Captured SKU at purchase time. |  |
| unit_price | mysql: DECIMAL(12,2) / postgres: NUMERIC(12,2) | NO |  | Unit price at purchase. |  |
| quantity | mysql: INT / postgres: INTEGER | NO |  | Quantity (> 0). |  |
| tax_rate | mysql: DECIMAL(5,2) / postgres: NUMERIC(5,2) | NO |  | Tax rate % (0..100). |  |
| currency | CHAR(3) | NO |  | ISO 4217 currency code. |  |
| created_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) | Creation timestamp (UTC). |  |
| updated_at | mysql: DATETIME(6) / postgres: TIMESTAMPTZ(6) | NO | CURRENT_TIMESTAMP(6) | Update timestamp (UTC). |  |

## Engine Details

### mysql

Unique keys:
| Name | Columns |
| --- | --- |
| ux_order_items_tenant_id | tenant_id, id |

Indexes:
| Name | Columns | SQL |
| --- | --- | --- |
| idx_order_items_book_id | book_id | INDEX idx_order_items_book_id (book_id) |
| idx_order_items_order_id | order_id | INDEX idx_order_items_order_id (order_id) |
| idx_order_items_tenant_book | tenant_id,book_id | INDEX idx_order_items_tenant_book (tenant_id, book_id) |
| idx_order_items_tenant_order | tenant_id,order_id | INDEX idx_order_items_tenant_order (tenant_id, order_id) |
| ux_order_items_tenant_id | tenant_id,id | CREATE UNIQUE INDEX ux_order_items_tenant_id ON order_items (tenant_id, id) |

Foreign keys:
| Name | Columns | References | Actions |
| --- | --- | --- | --- |
| fk_order_items_book | tenant_id,book_id | books(tenant_id,id) | ON UPDATE RESTRICT, ON DELETE CASCADE |
| fk_order_items_order | tenant_id,order_id | orders(tenant_id,id) | ON UPDATE RESTRICT, ON DELETE CASCADE |
| fk_order_items_tenant | tenant_id | tenants(id) | ON UPDATE RESTRICT, ON DELETE RESTRICT |

### postgres

Unique keys:
| Name | Columns |
| --- | --- |
| ux_order_items_tenant_id | tenant_id, id |

Indexes:
| Name | Columns | SQL |
| --- | --- | --- |
| idx_order_items_book_id | book_id | CREATE INDEX IF NOT EXISTS idx_order_items_book_id ON order_items (book_id) |
| idx_order_items_order_id | order_id | CREATE INDEX IF NOT EXISTS idx_order_items_order_id ON order_items (order_id) |
| idx_order_items_tenant_book | tenant_id,book_id | CREATE INDEX IF NOT EXISTS idx_order_items_tenant_book  ON order_items (tenant_id, book_id) |
| idx_order_items_tenant_order | tenant_id,order_id | CREATE INDEX IF NOT EXISTS idx_order_items_tenant_order ON order_items (tenant_id, order_id) |
| ux_order_items_tenant_id | tenant_id,id | CREATE UNIQUE INDEX IF NOT EXISTS ux_order_items_tenant_id ON order_items (tenant_id, id) |

Foreign keys:
| Name | Columns | References | Actions |
| --- | --- | --- | --- |
| fk_order_items_book | tenant_id,book_id | books(tenant_id,id) | ON UPDATE RESTRICT, ON DELETE CASCADE |
| fk_order_items_order | tenant_id,order_id | orders(tenant_id,id) | ON UPDATE RESTRICT, ON DELETE CASCADE |
| fk_order_items_tenant | tenant_id | tenants(id) | ON UPDATE RESTRICT, ON DELETE RESTRICT |

## Engine differences

## Views
| View | Engine | Flags | File |
| --- | --- | --- | --- |
| vw_order_items | mysql | algorithm=MERGE, security=INVOKER | [../schema/040_views.mysql.sql](../schema/040_views.mysql.sql) |
| vw_order_items_detailed | mysql | algorithm=TEMPTABLE, security=INVOKER | [../schema/040_views_joins.mysql.sql](../schema/040_views_joins.mysql.sql) |
| vw_order_items | postgres |  | [../schema/040_views.postgres.sql](../schema/040_views.postgres.sql) |
| vw_order_items_detailed | postgres |  | [../schema/040_views_joins.postgres.sql](../schema/040_views_joins.postgres.sql) |
