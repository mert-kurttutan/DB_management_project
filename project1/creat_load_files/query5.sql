SELECT COUNT(user_id)
FROM auction_users
WHERE rating > 1000 AND user_id IN (SELECT seller_id FROM items);

