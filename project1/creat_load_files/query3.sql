SELECT item_id, COUNT(*)
FROM category_item_rel
GROUP BY item_id
HAVING COUNT(*) = 4;

