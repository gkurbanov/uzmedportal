-- ignore-platform-reqs

# 07.06.2022
create table `anons`
(
    `id`                 int unsigned   not NULL auto_increment,
    `created_at`         DATETIME       not NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         DATETIME       not NULL DEFAULT CURRENT_TIMESTAMP,
    `year`               int(4),
    `month`              int(2),
    `title_ru`           varchar(255),
    `title_uz`           varchar(255),
    `content_ru`         longtext,
    `content_uz`         longtext,
    `image_ru`           varchar(255),
    `image_uz`           varchar(255),
    `slug`               varchar(255),
    `seo_title_ru`       varchar(100)   null,
    `seo_description_ru` varchar(200)   null,
    `seo_keyword_ru`     varchar(200)   null,
    `seo_title_uz`       varchar(100)   null,
    `seo_description_uz` varchar(200)   null,
    `seo_keyword_uz`     varchar(200)   null,
    `user_added`         int(3),
    `is_active`          enum ('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

create table `slider`
(
    `id`              int unsigned   not NULL auto_increment,
    `created_at`      DATETIME       not NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      DATETIME       not NULL DEFAULT CURRENT_TIMESTAMP,
    `title_ru`        varchar(255),
    `title_uz`        varchar(255),
    `button_text_ru`  varchar(50),
    `button_text__uz` varchar(50),
    `button_link_ru`  varchar(255),
    `button_link_uz`  varchar(255),
    `image`           varchar(255),
    `is_active`       enum ('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

create table related_resource
(
    `id`        int unsigned   not NULL auto_increment,
    `title_ru`  varchar(255),
    `title_uz`  varchar(255),
    `site_name` varchar(50),
    `link_url`  varchar(50),
    `image`     varchar(255),
    `is_active` enum ('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

create table `email_subscribe`
(
    `id`         int unsigned not NULL auto_increment,
    `added_at`   DATETIME     not NULL DEFAULT CURRENT_TIMESTAMP,
    `first_name` varchar(255) not null,
    `email`      varchar(255) UNIQUE,
    PRIMARY KEY (`id`)
);

# 08.06.2022
create table page
(
    `id`                 int unsigned   not NULL auto_increment,
    `is_active`          enum ('0','1') NOT NULL DEFAULT '0',
    `is_document`        enum ('0','1') NOT NULL DEFAULT '0',
    `is_main`            enum ('0','1') NOT NULL DEFAULT '0',
    `is_footer`          enum ('0','1') NOT NULL DEFAULT '0',
    `order_top`          int(3),
    `order_aside`        int(3),
    `order_footer`       int(3),
    `title_ru`           varchar(255),
    `title_uz`           varchar(255),
    `content_ru`         longtext,
    `content_uz`         longtext,
    `level`              int(2),
    `parent_id`          int(5),
    `slug`               varchar(255),
    `file`               varchar(255),
    `seo_title_ru`       varchar(100)   null,
    `seo_description_ru` varchar(255)   null,
    `seo_keyword_ru`     varchar(200)   null,
    `seo_title_uz`       varchar(100)   null,
    `seo_description_uz` varchar(255)   null,
    `seo_keyword_uz`     varchar(200)   null,
    PRIMARY KEY (`id`)
);

# 10.06.2022
create table main_setting
(
    `id`                         int unsigned not NULL auto_increment,
    `image`                      varchar(255),
    `seo_image`                  varchar(255),
    `site_name`                  varchar(100),
    `seo_title_ru`               varchar(100) null,
    `seo_description_ru`         varchar(255) null,
    `seo_keyword_ru`             varchar(200) null,
    `seo_title_uz`               varchar(100) null,
    `seo_description_uz`         varchar(255) null,
    `seo_keyword_uz`             varchar(200) null,
    `vk_link`                    varchar(200) null,
    `youtube_link`               varchar(200) null,
    `instagram_link`             varchar(200) null,
    `facebook_link`              varchar(200) null,
    `registered_users_count`     varchar(10),
    `educational_org_count`      varchar(10),
    `high_level_programs_count`  varchar(10),
    `interactive_programs_count` varchar(10),
    `studying_spec_count`        varchar(10),
    PRIMARY KEY (`id`)
);

# 13.06.2022
create table `events`
(
    `id`                 int unsigned   not NULL auto_increment,
    `created_at`         DATETIME       not NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         DATETIME       not NULL DEFAULT CURRENT_TIMESTAMP,
    `year`               int(4),
    `month`              int(2),
    `title_ru`           varchar(255),
    `title_uz`           varchar(255),
    `content_ru`         longtext,
    `content_uz`         longtext,
    `image_ru`           varchar(255),
    `image_uz`           varchar(255),
    `slug`               varchar(255),
    `seo_title_ru`       varchar(100)   null,
    `seo_description_ru` varchar(200)   null,
    `seo_keyword_ru`     varchar(200)   null,
    `seo_title_uz`       varchar(100)   null,
    `seo_description_uz` varchar(200)   null,
    `seo_keyword_uz`     varchar(200)   null,
    `user_added`         int(3),
    `is_active`          enum ('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);

# 14.06.2022
create table `projects`
(
    `id`                 int unsigned   not NULL auto_increment,
    `created_at`         DATETIME       NULL     DEFAULT CURRENT_TIMESTAMP,
    `updated_at`         DATETIME       NULL     DEFAULT CURRENT_TIMESTAMP,
    `year`               int(4),
    `month`              int(2),
    `title_ru`           varchar(255),
    `title_uz`           varchar(255),
    `content_ru`         longtext,
    `content_uz`         longtext,
    `image_ru`           varchar(255),
    `image_uz`           varchar(255),
    `slug`               varchar(255),
    `seo_title_ru`       varchar(100)   null,
    `seo_description_ru` varchar(200)   null,
    `seo_keyword_ru`     varchar(200)   null,
    `seo_title_uz`       varchar(100)   null,
    `seo_description_uz` varchar(200)   null,
    `seo_keyword_uz`     varchar(200)   null,
    `user_added`         int(3),
    `is_active`          enum ('0','1') NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
);