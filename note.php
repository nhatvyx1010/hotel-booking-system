CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED ,
  `category_name` varchar(255) ,
  `category_slug` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `blogcat_id` int(11) ,
  `user_id` int(11) ,
  `post_title` varchar(255) ,
  `post_slug` varchar(255) ,
  `post_image` varchar(255) ,
  `short_desc` text ,
  `long_desc` text ,
  `audio_file` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED ,
  `rooms_id` int(11) ,
  `user_id` int(11) ,
  `check_in` varchar(255) ,
  `check_out` varchar(255) ,
  `persion` varchar(255) ,
  `number_of_rooms` varchar(255) ,
  `total_night` double(8,2)  DEFAULT 0.00,
  `actual_price` int(11)  DEFAULT 0,
  `subtotal` int(11)  DEFAULT 0,
  `discount` int(11)  DEFAULT 0,
  `total_price` int(11)  DEFAULT 0,
  `service_fee` int(11)  DEFAULT 0 COMMENT 'Phí dịch vụ theo %',
  `payment_method` varchar(255) ,
  `transation_id` varchar(255) ,
  `payment_status` varchar(255) ,
  `name` varchar(255) ,
  `email` varchar(255) ,
  `phone` varchar(255) ,
  `country` varchar(255) ,
  `state` varchar(255) ,
  `zip_code` varchar(255) ,
  `address` varchar(255) ,
  `code` varchar(255) ,
  `prepaid_amount` int(11) ,
  `remaining_amount` int(11) ,
  `total_amount` int(11) ,
  `cancel_reason` varchar(255) ,
  `refund_phone` text ,
  `refund_bank_code` text ,
  `refund_bank_name` text ,
  `status` int(11)  DEFAULT 1,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `booking_room_lists` (
  `id` bigint(20) UNSIGNED ,
  `booking_id` int(11) ,
  `room_id` int(11) ,
  `room_number_id` int(11) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `book_areas` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `image` varchar(255) ,
  `short_title` varchar(255) ,
  `main_title` varchar(255) ,
  `short_desc` text ,
  `link_url` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED ,
  `name` varchar(255) ,
  `description` text ,
  `image` varchar(255) ,
  `slug` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 


CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED ,
  `user_id` int(10) UNSIGNED ,
  `post_id` int(10) UNSIGNED ,
  `message` text ,
  `status` varchar(255)  DEFAULT '0',
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `rooms_id` int(11) ,
  `facility_name` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `photo_name` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `multi_images` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `rooms_id` int(11) ,
  `multi_img` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `notifications` (
  `id` char(36) ,
  `type` varchar(255) ,
  `notifiable_type` varchar(255) ,
  `notifiable_id` bigint(20) UNSIGNED ,
  `data` text ,
  `read_at` timestamp NULL ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED ,
  `user_id` bigint(20) UNSIGNED ,
  `hotel_id` bigint(20) UNSIGNED ,
  `booking_id` bigint(20) UNSIGNED ,
  `message` text ,
  `status` enum('pending','reviewed','resolved')  DEFAULT 'pending',
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` bigint(20) UNSIGNED ,
  `user_id` bigint(20) UNSIGNED ,
  `booking_id` bigint(20) ,
  `parent_id` bigint(20) ,
  `comment` text ,
  `rating` tinyint(3) UNSIGNED ,
  `status` enum('pending','approved','rejected')  DEFAULT 'pending',
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `roomtype_id` int(11) ,
  `total_adult` varchar(255) ,
  `total_child` varchar(255) ,
  `room_capacity` varchar(255) ,
  `image` varchar(255) ,
  `price` varchar(255) ,
  `size` varchar(255) ,
  `view` varchar(255) ,
  `bed_style` varchar(255) ,
  `discount` int(11)  DEFAULT 0,
  `short_desc` text ,
  `description` text ,
  `status` int(11)  DEFAULT 1,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `room_booked_dates` (
  `id` bigint(20) UNSIGNED ,
  `booking_id` int(11) ,
  `room_id` int(11) ,
  `book_date` date ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `room_numbers` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `rooms_id` int(11) ,
  `room_type_id` int(11) ,
  `room_no` varchar(255) ,
  `status` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `room_special_prices` (
  `id` bigint(20) UNSIGNED ,
  `room_id` bigint(20) UNSIGNED ,
  `start_date` date ,
  `end_date` date ,
  `special_price` bigint(20) ,
  `description` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `room_types` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `name` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED ,
  `logo` varchar(255) ,
  `phone` varchar(255) ,
  `address` text ,
  `email` varchar(255) ,
  `facebook` varchar(255) ,
  `twitter` varchar(255) ,
  `copyright` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `smtp_settings` (
  `id` bigint(20) UNSIGNED ,
  `mailer` varchar(255) ,
  `host` varchar(255) ,
  `port` varchar(255) ,
  `username` varchar(255) ,
  `password` varchar(255) ,
  `encryption` varchar(255) ,
  `from_address` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED ,
  `hotel_id` int(11) ,
  `image` varchar(255) ,
  `name` varchar(255) ,
  `position` varchar(255) ,
  `facebook` varchar(255) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED ,
  `name` varchar(255) ,
  `city` varchar(255) ,
  `image` varchar(255) ,
  `message` text ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED ,
  `name` varchar(255) ,
  `email` varchar(255) ,
  `email_verified_at` timestamp NULL ,
  `password` varchar(255) ,
  `photo` varchar(255) ,
  `phone` varchar(255) ,
  `city_id` int(11) ,
  `address` text ,
  `role` enum('admin','user','hotel')  DEFAULT 'user',
  `status` enum('active','inactive','pending','cancelled')  DEFAULT 'active',
  `hotel_audio` varchar(255) ,
  `remember_token` varchar(100) ,
  `created_at` timestamp NULL ,
  `updated_at` timestamp NULL 
) 
