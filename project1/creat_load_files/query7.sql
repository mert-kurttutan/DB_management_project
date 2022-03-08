SELECT COUNT(DISTINCT ci_rel.category)
FROM category_item_rel ci_rel JOIN items it JOIN bids bi ON
ci_rel.item_id = it.item_id AND it.item_id = bi.item_id
WHERE bi.amount > 100;