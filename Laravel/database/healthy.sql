CREATE DATABASE healthy DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use healthy;
CREATE TABLE customer(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    address VARCHAR(250) NULL,
    birthday date NOT NULL,
    gender tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    deleted_at timestamp NUll
);
CREATE TABLE banner(
    id int PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR (255) NOT NULL,
    image VARCHAR(100) NOT NULL,
    link VARCHAR(150) NUll,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);
CREATE TABLE categoryBlog(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);
CREATE TABLE blog(
    id int PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR (255) NOT NULL,
    image VARCHAR(100) NOT NULL,
    content VARCHAR(255) NOT NULL,
    categoryBlog_id int,
    status tinyint DEFAULT 1,
    FOREIGN KEY (categoryBlog_id) REFERENCES categoryBlog(id),
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);
CREATE TABLE categoryProduct(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);
CREATE TABLE product(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    image VARCHAR(100) NOT NULL,
    content text NOT NULL,
    price float NOT NULL,
    categoryProduct_id int ,
    status tinyint DEFAULT 1,
    FOREIGN KEY (categoryProduct_id) REFERENCES categoryProduct(id) ON DELETE CASCADE,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    deleted_at timestamp NUll
);
CREATE TABLE favoriteProduct(
    id int PRIMARY KEY AUTO_INCREMENT,
    product_id int NOT NULL,
    customer_id int NOT NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
CREATE TABLE ratingProduct(
    id int PRIMARY KEY AUTO_INCREMENT,
    product_id int NOT NULL,
    customer_id int NOT NULL,
    start float NOT NULL,
    content text NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY ( customer_id) REFERENCES customer(id)
);
CREATE TABLE product_images(
    id int PRIMARY KEY AUTO_INCREMENT,
    product_id int NOT NULL,
    image VARCHAR(200) NULL,
    status tinyint DEFAULT 1,
    FOREIGN KEY (product_id) REFERENCES product(id), 
    created_at timestamp DEFAULT current_timestamp(),
     updated_at timestamp NULL
);
CREATE TABLE admin(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
     deleted_at timestamp NUll
   
);
CREATE TABLE orders(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,
    address VARCHAR(250) NULL,
    total_price float NOT NULl,
    status tinyint DEFAULT 1,
    customer_id INT NOT NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
CREATE TABLE orderdetail(
    id int PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    order_id int NOT NULL,
    price float NOT NULL,
    quantity float NOT NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
CREATE TABLE carts(
    id int PRIMARY KEY AUTO_INCREMENT,
    product_id int NOT NULL,
    customer_id int NOT NULL ,
    price float NOT NULL,
    quantity text NOT NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    deleted_at timestamp NUll,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
    FOREIGN KEY ( customer_id) REFERENCES customer(id) ON DELETE CASCADE
   
);
CREATE TABLE logo(
    id int PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(200) NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);

CREATE TABLE categoryVideo(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);
CREATE TABLE video(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    video VARCHAR(255) NOT NULL,
    content VARCHAR(255) NOT NULL,
    categoryVideo_id int ,
    status tinyint DEFAULT 1,
    FOREIGN KEY (categoryVideo_id) REFERENCES categoryVideo(id) ON DELETE CASCADE,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    deleted_at timestamp NUll
);
CREATE TABLE favoriteVideo(
    id int PRIMARY KEY AUTO_INCREMENT,
    video_id int NOT NULL,
    customer_id int NOT NULL,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (video_id) REFERENCES video(id),
    FOREIGN KEY (customer_id) REFERENCES customer(id)
);
CREATE TABLE ratingVideo(
    id int PRIMARY KEY AUTO_INCREMENT,
    video_id int NOT NULL,
    customer_id int NOT NULL,
    content text NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (video_id) REFERENCES video(id),
    FOREIGN KEY ( customer_id) REFERENCES customer(id)
);
CREATE TABLE answer(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(100) NOT NULL UNIQUE,
    answer VARCHAR(255) NOT NULL ,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL

);
CREATE TABLE feedback(
    id int PRIMARY KEY AUTO_INCREMENT,
    customer_id int,
    product_id int,
    content VARCHAR(255) NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL,
    FOREIGN KEY (customer_id) REFERENCES customer(id),
    FOREIGN KEY ( product_id) REFERENCES product(id)
);
CREATE TABLE payments(
    id int PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    status tinyint DEFAULT 1,
    created_at timestamp DEFAULT current_timestamp(),
    updated_at timestamp NULL
);

INSERT INTO categoryproduct(name,status) VALUES
('Thuốc tiêm',1),
('Thuốc uống',2)
INSERT INTO product (name, image,content, price,categoryProduct_id,status)VALUES 
("Sustanon-250-MEDITECH/Hộp/10 ống", "111.jpg","Thành phần:
Dung dịch dầu tiêm bắp 250 mg/ml : ống 1 ml, hộp 1 ống
Cho 1 ống thuốc, Gồm 4 loại Testosteron
Testosterone propionate    30 mg
Testosterone phénylpropionate    60 mg
Testosterone isocaproate    60 mg
Testosterone decanoate    100 mg
Nơi sản xuất:
Germany (Đức)
Dược động học
Sustanon-250mg bao gồm 4 loại ester của testosterone. Sau khi tiêm bắp, lần lượt 4 ester này được phóng thích dần vào máu : nồng độ cao nhất trong huyết tương đạt được trong 2 ngày đầu sau đó giảm dần. Nồng độ này giữ ở mức bình thường từ sau tuần lễ đầu cho đến ngày thứ 21.
Chỉ định
Các rối loạn thiểu năng sinh dục ở nam giới : sau khi hoạn, bất lực do thiếu hormone, triệu chứng tắc dục ở nam giới như giảm khoái cảm sinh dục và các hoạt động tâm sinh lý, một vài dạng vô sinh do các rối loạn tạo tinh trùng.
Được chỉ định điều trị chứng loãng xương do giảm androgene. 
Chống chỉ định
Ung thư tuyến tiền liệt hoặc ung thư tuyến vú đã biết hoặc nghi ngờ ung thư vú ở nam giới.
Thận trọng lúc dùng
Ngưng thuốc nếu thấy xuất hiện các tác dụng ngoại ý, sau khi các triệu chứng này biến mất, dùng thuốc lại với liều thấp hơn.
Dùng thuốc cẩn thận cho người bị suy tim, cao huyết áp, động kinh, nhức nửa đầu.
Androgène phải được sử dụng thận trọng ở trẻ nam trước tuổi dậy thì nhằm tránh sự cốt hóa sụn hoặc sự phát triển sinh dục sớm.
Tác dụng ngoại ý
Một số tác dụng ngoại ý có thể xảy ra trong thời gian điều trị bằng nội tiết tố nam :
Dương vật cương đau hoặc các dấu hiệu tăng kích thích sinh dục khác.
Ở trẻ nam trong giai đoạn tiền dậy thì : phát triển sinh dục sớm, xuất tinh thường hơn, tăng thể tích dương vật, cốt hóa sớm các sụn liên hợp.
Ít tinh trùng và giảm thể tích tinh dịch.
Giữ nước muối.
Liều lượng và cách dùng Sustanon 250 Meditech
Đường tiêm bắp sâu.
Liều được điều chỉnh theo bệnh nhân. Thông thường, nên dùng 1 mũi tiêm 1 ml mỗi 3 tuần.",1100000, 1,1),

("Testoviron-Depot-250-(NÂU)-250mg/Hộp/3 ống", "2.jpg","- Testoviron Depot hay còn gọi là Depot Nâu là sản phẩm dùng để bổ sung testosterone cho nam giới đối với các trường hợp thiếu hụt Testosterone và tình trạng loãng xương do thiếu androgen.
- Depot Nâu có tác dụng tăng cơ bắp và râu, làm tăng sức mạnh cho vận động viên thể hình và người chơi thể thao.
- Depot Nâu còn được dùng trong liệu pháp thay thế hocmon (Hormone Replacement Therapy - HRT)
Hạn sử dụng: 2023
Thành phần: Testosterone enantate 250mg/ml
Quy cách đóng gói: 3 lọ/ hộp
Sản xuất ở : Pakistan
Hãng: Bayer - Đức",440.000, 1,1),
("TESTO DEPOT - TESTOSTERON ENANTHATE 250MG (TEST E) - HÃNG MEDITECH - LỌ 10ML", "3.jpg","Chỉ định Testosterone enanthate :
 Là một loại thuốc androgen và đồng hóa steroid (AAS) được sử dụng chủ yếu trong điều trị nồng độ testosterone thấp ở nam giới. Nó cũng được sử dụng trong liệu pháp hormone cho người chuyển giới. Nó được tiêm bằng cách tiêm bắp thường cứ sau một đến bốn tuần một lần.
Tác dụng phụ của testosterone enanthate:
bao gồm các triệu chứng nam tính như mụn trứng cá, tăng trưởng tóc, thay đổi giọng nói và tăng ham muốn tình dục. Thuốc là một steroid tổng hợp androgen và đồng hóa và do đó là chất chủ vận của thụ thể androgen (AR), mục tiêu sinh học của androgen như testosterone và dihydrotestosterone (DHT). Nó có tác dụng androgen mạnh và tác dụng đồng hóa vừa phải, giúp ích cho việc sản xuất nam tính và phù hợp với liệu pháp thay thế androgen. Testosterone enanthate là một este testosterone và lâu dài tiền chất của testosterone trong cơ thể. Bởi vì điều này, nó được coi là một dạng testosterone tự nhiên và sinh học. 
Testosterone enanthate được giới thiệu cho sử dụng y tế vào năm 1954. Cùng với testosterone cypionate, testosterone unecanoate và testosterone propionate, nó là một trong những estrogen testosterone được sử dụng rộng rãi nhất. Ngoài việc sử dụng trong y tế, testosterone enanthate được sử dụng để cải thiện vóc dáng và hiệu suất.Thuốc là một chất được kiểm soát ở nhiều quốc gia và vì vậy sử dụng phi y tế nói chung là bất hợp pháp.
Cách sử dụng: Tiêm bắp sâu (tiêm mông hoặc tiêm đùi) 
Với  liệu pháp hormone cho người chuyển giới liều là 21 ngày/lần tiêm 1 ml hoặc theo chỉ định bác sĩ.
Hãng sản xuất: Hãng Meditech",990000, 1,1),
("TESTOSTERONE Enanthate - Testobolin/ hộp / 5 ống", "4.jpg","Testosterone (Tiêm) là một hormone giới tính tự nhiên ở nam và nữ. Thuốc này được sử dụng để điều trị các điều kiện gây ra bởi mức độ thấp của hormone testosterone trong cơ thể. Những tình trạng này bao gồm dậy thì muộn, bất lực và mất cân bằng nội tiết tố khác.
Liệu pháp thay thế hoocmon từ nữ sang nam (FTM)
Tác dụng phụ
Phì đại tuyến vú ở nam giới NGHIÊM TRỌNG
Tăng cân NẶNG
Mụn trứng cá
Rụng tóc
Đau tại vết tiêm
Đau họng
Thay đổi khẩu vị
Khô miệng
Khó ngủ
Hoạt động, Cơ chế hoạt động và Dược lý học của Testosterone Enanthate Injection
Testosterone Enanthate cải thiện tình trạng của người bệnh bằng cách thực hiện những chức năng sau:
Thay thế testosterone thường được sản xuất trong cơ thể.
Bổ sung testosterone tự nhiên được tạo ra trong cơ thể.",1000000, 1,1),
("Sustanon 250 - Aspen (Sus Xanh) - Sustanon/ hộp / 1 ống", "5.jpg","Điều trị thiểu năng tuyền sinh dục ở nam giới với Sustanon làm tăng đáng kể trên lâm sàng nồng độ testosterone, dihydrotẹstosterone, estradiol và androstenedione trong huyết tương, cũng như làm giảm SHBG (globulin gắn kết hormone sinh dục).
Hormone tạo hoàng thể (LH) và hormone kích thích buồng trứng (FSH) được phục hồi vè giới hạn bình thường. Ở nam giới thiểu năng tuyến sinh dục, điều trị với Sustanon có kết quả cải thiện các triệu chứng do thiếu hụt testosterone.
Tuy nhiên việc điều trị này cũng tăng mật độ khoáng trong xương và thể trọng cơ thể không mở, và giảm khối mỡ của cơ thể. Việc điều trị cũng cải thiện chức năng sinh dục, bao gồm sự ham muốn và chức năng cương cứng.
Điều trị làm giảm LDL-C, HDL-C vá triglycéride trong huyết tương, tăng hemoglobin và hemotocrit, trong khi không ghi nhận những thay đổi men gan và PSA liên quan đến lâm sàng. Việc điều trị này có thể gây tăng kích cỡ tuyến tiền liệt, nhưng không thấy các tác dụng bất lợi trên tuyến tiền liệt, ở những bệnh nhân tiểu đường thiểu năng sinh dục, đã ghi nhận tăng nhạy cảm với insuline và/hoặc giảm glucose máu khi sử dụng androgen.
Ở những bé trai chậm phát triển thể chất và dậy thì, điều trị với androgen thúc đẩy quá trình phát triển và kích thích sự phát triển các đặc tính sinh dục. Ở những người chuyển đổi giới tính từ nữ sang nam, điều trị với androgen/Sustanon gây nam tính hóa.",250000, 1,1)

INSERT INTO product (name, image,content, price,categoryProduct_id,status)VALUES 
("Tribulus Maximus BiotechUSA Hộp 90 viên", "6.jpg","Đóng góp vào sự phát triển và xây dựng cơ bắp
Tăng hóc môn nam giúp tăng sức mạnh, tăng khả năng phục hồi cho cơ bắp. Thông qua đó tăng tốc độ phát triển cơ bắp.
Loại thảo dược có hoạt tính cao nhất và an toàn nhất để tăng cường sinh lực tình dục cho nam giới.
Giúp bổ sung hóoc môn nam, giúp kéo dài thời gian hoạt động tình dục, giúp quá trình phục hồi sau khi quan hệ tình dục diễn ra nhanh chóng.
Đối với riêng với các vận động viên thể hình: giúp hỗ trợ tăng sức mạnh cơ bắp và chuyển các chất béo dự trữ tạo năng lượng xây dựng cơ bắp, giảm mệt mỏi trong quá trình tập luyện và đặc biệt Tribulus được chiết suất tự nhiên, đảm bảo an toàn cho người sử dụng chống oxi hóa nhờ hoạt tính chống oxi hóa giảm nguy cơ ung thư, tăng cường sức khỏe của xương và kích thích hệ miễn dịch.
Hướng dẫn sử dụng: Ngày uống 1 Viên – Hộp 90 Viên.",590000, 2,1),
("TST+GH BiotechUSA Hộp 300g", "7.jpg","",640000, 2,1),
