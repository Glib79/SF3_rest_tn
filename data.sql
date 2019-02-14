INSERT INTO sf3.category (name, created_at, modified_at) VALUES
("Games",now(), now()),
("Computers",now(), now()),
("TVs and Accessories",now(), now());

INSERT INTO sf3.product (category_id, name, sku, price, quantity, created_at, modified_at) VALUES
(1,"Pong","A0001",69.99,20,now(),now()),
(1,"GameStation 5","A0002",269.99,15,now(),now()),
(2,"AP Oman PC - Aluminum","A0003",1399.99,10,now(),now()),
(3,"Fony UHD HDR 55\" 4k TV","A0004",1399.99,5,now(),now());
