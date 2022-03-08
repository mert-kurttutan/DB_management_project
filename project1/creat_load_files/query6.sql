SELECT COUNT(user_id)
FROM auction_users 
WHERE user_id IN (SELECT seller_id FROM items) AND
	user_id IN (SELECT bidder_id FROM bids);

