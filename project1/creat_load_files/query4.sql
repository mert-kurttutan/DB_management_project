SELECT item_id, currently
FROM items
WHERE currently = (SELECT MAX(currently) FROM items);
