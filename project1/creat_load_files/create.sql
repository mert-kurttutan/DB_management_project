DROP TABLE IF EXISTS category_item_rel;
DROP TABLE IF EXISTS bids;
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS auction_users;

CREATE TABLE auction_users(
    user_id INT NOT NULL PRIMARY KEY,
    rating INT NOT NULL,
    location VARCHAR(50) NOT NULL,
    country VARCHAR(30) NOT NULL
    
);

CREATE TABLE items(
    item_id INT NOT NULL PRIMARY KEY,
    name VARCHAR(30),
    currently DECIMAL(8, 4),
    buy_price DECIMAL(8, 4),
    first_bid DECIMAL(8, 4),
    number_of_bids INT,
    started VARCHAR(30),
    ends VARCHAR(30),
    seller_id INT,
    description VARCHAR(500),
    FOREIGN KEY (seller_id) REFERENCES auction_users(user_id)
);

CREATE TABLE bids(
    item_id INT,
    bidder_id INT NOT NULL,
    time VARCHAR(30),
    amount DECIMAL(8, 4),
    FOREIGN key (bidder_id) REFERENCES auction_users(user_id),
    FOREIGN KEY (item_id) REFERENCES items(item_id)
    PRIMARY KEY( item_id, bidder_id, amount)
);

CREATE TABLE category_item_rel(
    item_id INT,
    category VARCHAR(50),
    FOREIGN KEY (item_id) REFERENCES items(item_id)
);