python skeleton_parser.py ebay_data/items-*.json

TARGET="dat_files"

sort -u ${TARGET}/items.dat -o ${TARGET}/itemsUnique.dat
sort -u ${TARGET}/categories.dat -o ${TARGET}/categoriesUnique.dat
sort -u ${TARGET}/bids.dat -o ${TARGET}/bidsUnique.dat
sort -u ${TARGET}/users.dat -o ${TARGET}/usersUnique.dat