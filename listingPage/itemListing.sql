CREATE DATABASE malaysia_attractions CHARACTER SET utf8 COLLATE utf8_general_ci;
USE malaysia_attractions;

-- create states table
CREATE TABLE states(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    code VARCHAR(5) NOT NULL UNIQUE
);


-- create attractions table
CREATE TABLE attractions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    state_id INT NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0,
    review_count INT DEFAULT 0,
    booking_count INT DEFAULT 0,
    type ENUM('indoor','outdoor', 'both') NOT NULL,
    accessibility VARCHAR(100) DEFAULT 'none',
    image_url VARCHAR(255),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (state_id) REFERENCES states(id)
);



-- create search table
CREATE TABLE searches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    search_term VARCHAR(255) NOT NULL,
    state_id INT NULL,
    price_range VARCHAR(50) NULL,
    user_ip VARCHAR(45) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (state_id) REFERENCES states(id)
);


-- insert available Malaysia states into states table
INSERT INTO states (name, code) VALUES
('Kuala Lumpur', 'KUL'),
('Johor', 'JHR'),
('Kedah', 'KDH'),
('Pahang', 'PHG'),
('Penang', 'PNG'),
('Perak', 'PRK'),
('Sabah', 'SBH'),
('Sarawak', 'SRW');


-- insert available attractions
-- Kuala Lumpur attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('PETRONAS Twin Towers', 1, 'Kuala Lumpur', 60.00, 5.0, 69000, 108000, 'indoor', 'wheelchair accessible, guided tours, public transport, restroom accessibility, cafeteria', '../attraction/kl/twintower.jpg'),
('KL Tower', 1, 'Kuala Lumpur', 30.00, 5.0, 52000, 92000, 'indoor', 'wheelchair accessible, guided tours, public transport, restroom accessibility, cafeteria', '../attraction/kl/klTower.jpg'),
('Putrajaya Pink Mosque & River Cruise', 1, 'Putrajaya', 65.00, 5.0, 2600, 116000, 'outdoor', 'guided tours, restroom accessibility', '../attraction/kl/mosque.jpg'),
('Batu Caves', 1, 'Batu Caves', 7.00, 5.0, 1800, 11000, 'outdoor', 'pet friendly, guided tours', '../attraction/kl/batu-cave.jpg'),
('Aquaria KLCC', 1, 'Kuala Lumpur', 40.00, 3.8, 2000, 13200, 'indoor', 'wheelchair accessible, kid friendly, cafeteria, restroom accessibility, public transport', '../attraction/kl/aquarium.jpg'),
('Zoo Negara Malaysia', 1, 'Selangor', 38.00, 3.0, 688, 2000, 'outdoor', 'kid-friendly', '../attraction/kl/zoo.jpg');


-- Johor attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('LEGOLAND Malaysia Ticket', 2, 'Johor Bahru', 105.00, 5.0, 3800, 43000, 'outdoor', 'kid friendly, cafeteria, restroom accessibility, parking availability', '../attraction/johor/legoland.jpg'),
('Adventure Waterpark Desaru Coast Ticket', 2, 'Desaru', 85.00, 5.0, 2900, 33000, 'outdoor', 'kid friendly, cafeteria, restroom accessibility, parking availability', '../attraction/johor/waterparkDesaru.jpg'),
('Skyscape at Menara Jland Ticket', 2, 'Pontian', 28.00, 4.5, 1500, 19000, 'outdoor', 'wheelchair accessible, restroom accessibility, cafeteria', '../attraction/johor/skyscape.jpg'),
('Tanjung Piai National Park Ticket', 2, 'Kukup', 16.00, 4.0, 1200, 19300, 'outdoor', 'guided tours, pet friendly', '../attraction/johor/tanjungPiai.jpg'),
('Putuo Village Ticket', 2, 'Kulai', 10.00, 3.0, 208, 600, 'outdoor', 'kid friendly, restroom accessibility', '../attraction/johor/putuoVillage.jpg'),
('Zoo Johor Ticket', 2, 'Johor Bahru', 10.00, 2.5, 321, 700, 'outdoor', 'kid friendly, parking availability, restroom accessibility, cafeteria', '../attraction/johor/zooJohor.jpg');

-- Kedah attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('Langkawi SkyCab Ticket', 3, 'Langkawi', 40.00, 5.0, 8300, 58000, 'indoor', 'guided tours', '../attraction/kedah/cablecar.jpg'),
('Dream Forest Langkawi Ticket', 3, 'Langkawi', 68.00, 5.0, 5800, 5950, 'indoor', 'kid friendly, guided tours, visual assistance', '../attraction/kedah/dreamForest.jpg'),
('Langkawi Sky Bridge', 3, 'Langkawi', 6.00, 4.8, 2900, 31000, 'indoor', 'wheelchair accessible, restroom accessibility, parking availability', '../attraction/kedah/skybridge.jpg'),
('Crocodile Adventureland Langkawi', 3, 'Langkawi', 40.00, 4.5, 1800, 11000, 'outdoor', 'kid friendly, cafeteria, restroom accessibility, parking availability', '../attraction/kedah/crocodileAdventure.jpg'),
('Langkawi WildLife Park Ticket', 3, 'Langkawi', 45.00, 4.0, 2000, 12000, 'outdoor', 'kid friendly, pet friendly, cafeteria, restroom accessibility', '../attraction/kedah/wildLifePark.jpg'),
('Kedah Paddy Museum Ticket', 3, 'Kedah', 3.00, 2.0, 121, 651, 'indoor', 'kid friendly, parking availability', '../attraction/kedah/paddy.jpg');

-- Pahang attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('Genting SkyWorlds Theme Park Ticket', 4, 'Genting Highlands', 168.00, 5.0, 4200, 56000, 'outdoor', 'kid friendly, cafeteria, restroom accessibility', '../attraction/pahang/skyWorld.jpg'),
('Cameron Highlands Flora Park Ticket', 4, 'Brinchang', 50.00, 5.0, 2600, 47000, 'outdoor', 'kid friendly, restroom accessibility', '../attraction/pahang/floraPark.jpg'),
('The Sheep Sanctuary Ticket in Cameron Highland Ticket', 4, 'Brinchang', 12.00, 4.8, 2600, 29000, 'outdoor', 'kid friendly, pet friendly, cafeteria, restroom accessibility', '../attraction/pahang/sheepSanctuary.jpg'),
('Bukit Tinggi Ticket', 4, 'Bentong', 14.00, 4.5, 1700, 19000, 'outdoor', 'guided tours', '../attraction/pahang/bukitTinggi.jpg'),
('Genting Skytropolis Indoor Theme Park Tickets', 4, 'Genting Highlands', 63.00, 4.0, 2500, 29600, 'indoor', 'kid friendly, cafeteria', '../attraction/pahang/skyTropolis.jpg'),
('Fraser Hill Ticket', 4, 'Raub', 13.00, 3.5, 128, 971, 'outdoor', 'guided tours, parking availability, cafeteria', '../attraction/pahang/fraserHill.jpg');

-- Penang attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('The Habitat Penang Hill Ticket', 5, 'Bukit Bendera', 60.00, 5.0, 8000, 31000, 'outdoor', 'guided tours, kid friendly, restroom accessibility, cafeteria', '../attraction/penang/habitat.jpg'),
('The TOP Penang Ticket', 5, 'Georgetown', 70.00, 5.0, 5000, 16000, 'outdoor', 'wheelchair accessible, guided tours, parking availability', '../attraction/penang/topPenang.jpg'),
('Kek Lok Si Temple Ticket', 5, 'Ayer Itam', 2.00, 4.5, 3000, 13000, 'outdoor', 'guided tours', '../attraction/penang/kekloksi.jpg'),
('ESCAPE Penang Ticket', 5, 'Georgetown', 188.00, 4.5, 6000, 16000, 'outdoor', 'kid friendly, parking availability, restroom accessibility, cafeteria', '../attraction/penang/escape.jpg'),
('Penang History Gallery Ticket at George Town', 5, 'Georgetown', 35.00, 3.0, 1000, 3, 'indoor', 'kid friendly, parking availability', '../attraction/penang/historyGallery.jpg'),
('Tech Dome Penang Ticket', 5, 'Georgetown', 28.00, 2.0, 103, 783, 'indoor', 'kid friendly', '../attraction/penang/techDome.jpg');

-- Perak attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('The Banjaran Hotsprings Retreat', 6, 'Ipoh', 350.00, 5.0, 5800, 68000, 'outdoor', 'parking availability, cafeteria', '../attraction/perak/hotSpring.jpg'),
('Sunway Lost World of Tambun Ticket', 6, 'Ipoh', 80.00, 5.0, 2100, 29000, 'outdoor', 'kid friendly, parking availability, cafeteria, restroom accessibility', '../attraction/perak/lostWorld.jpg'),
('Kampar White Water Rafting Adventure Ticket', 6, 'Kampar', 155.00, 4.8, 2900, 33000, 'outdoor', 'parking availability', '../attraction/perak/rafting.jpg'),
('Zoo Taiping & Night Safari Ticket', 6, 'Taiping', 16.00, 4.8, 1900, 23000, 'outdoor', 'kid friendly, parking availability, restroom accessibility', '../attraction/perak/taipingZoo.jpg'),
('Kellie''s Castle Ticket', 6, 'Batu Gajah', 9.00, 4.0, 1300, 27000, 'outdoor', 'parking availability, cafeteria, restroom accessibility', '../attraction/perak/kellieCastle.jpg'),
('Gaharu Tea Valley Ticket', 6, 'Gopeng', 13.00, 3.5, 121, 651, 'outdoor', 'parking availability, cafeteria, restroom accessibility', '../attraction/perak/teaValley.jpg');

-- Sabah attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('Mount Kinabalu Ticket', 7, 'Kota Kinabalu', 120.00, 5.0, 4000, 25000, 'outdoor', 'guided tours, parking availability', '../attraction/sabah/mountKinabalu.jpg'),
('Semporna Islands Hopping, Snorkeling, Hiking', 7, 'Tawau', 355.00, 5.0, 2300, 22000, 'outdoor', 'guided tours', '../attraction/sabah/semporna.jpg'),
('Desa Dairy Farm Ticket', 7, 'Kundasang', 75.00, 5.0, 1600, 17000, 'outdoor', 'kid friendly, parking availability, cafeteria, guided tours', '../attraction/sabah/desaFarm.jpg'),
('Mari Mari Cultural Village', 7, 'Kota Kinabalu', 130.00, 4.0, 6000, 5000, 'outdoor', 'guided tours', '../attraction/sabah/cultural.jpg'),
('ATV Kundasang Ticket', 7, 'Kundasang', 80.00, 3.0, 130, 500, 'outdoor', 'restroom accessibility, parking availability', '../attraction/sabah/atv.jpg'),
('Sabah State Museum Ticket', 7, 'Kota Kinabalu', 2.00, 2.0, 62, 100, 'indoor', 'parking availability, restroom accessibility, kid friendly', '../attraction/sabah/museum.jpg');

-- Sarawak attractions
INSERT INTO attractions (name, state_id, category, price, rating, review_count, booking_count, type, accessibility, image_url) VALUES
('Gunung Gading Ticket', 8, 'Lundu', 10.00, 5.0, 6000, 15000, 'outdoor', 'guided tours, pet friendly', '../attraction/sarawak/gunungGading.jpg'),
('Gunung Mulu Ticket', 8, 'Miri', 15.00, 5.0, 4000, 18000, 'outdoor', 'guided tours', '../attraction/sarawak/gunungMulu.jpg'),
('Royal Kuching River Cruise Experience', 8, 'Kuching', 69.00, 4.5, 5000, 7000, 'outdoor', 'cafeteria, restroom accessibility', '../attraction/sarawak/sarawakCruise.jpg'),
('Bako National Park Ticket', 8, 'Kuching', 10.00, 3.5, 659, 1000, 'outdoor', 'wheelchair accessible, guided tours, restroom accessibility', '../attraction/sarawak/nationalPark.jpg'),
('Kuching City Tour', 8, 'Kuching', 80.00, 3.0, 130, 500, 'both', 'guided tour, public transport', '../attraction/sarawak/kuchingCity.jpg'),
('The Wind Cave Nature Reserve Ticket', 8, 'Bau', 1.00, 2.0, 62, 100, 'outdoor','guided tour', '../attraction/sarawak/windCave.jpg');
