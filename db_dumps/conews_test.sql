/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50713
Source Host           : localhost:3306
Source Database       : conews_test

Target Server Type    : MYSQL
Target Server Version : 50713
File Encoding         : 65001

Date: 2016-11-02 00:58:36
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_fkey` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_assignment_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_assignment
-- ----------------------------
INSERT INTO `auth_assignment` VALUES ('Confirmed', '1', '1477942732');
INSERT INTO `auth_assignment` VALUES ('Confirmed', '3', '1477941715');
INSERT INTO `auth_assignment` VALUES ('Confirmed', '5', '1477941716');
INSERT INTO `auth_assignment` VALUES ('Confirmed', '7', '1477942731');
INSERT INTO `auth_assignment` VALUES ('Confirmed', '8', '1477942732');
INSERT INTO `auth_assignment` VALUES ('Registered', '2', '1477941714');
INSERT INTO `auth_assignment` VALUES ('Registered', '4', '1477941715');
INSERT INTO `auth_assignment` VALUES ('Registered', '6', '1477941716');

-- ----------------------------
-- Table structure for auth_item
-- ----------------------------
DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item
-- ----------------------------
INSERT INTO `auth_item` VALUES ('Confirmed', '1', null, null, null, '1477940357', '1477940357');
INSERT INTO `auth_item` VALUES ('Registered', '1', null, null, null, '1477940357', '1477940357');

-- ----------------------------
-- Table structure for auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_item_child
-- ----------------------------

-- ----------------------------
-- Table structure for auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for migration
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1477939668');
INSERT INTO `migration` VALUES ('m140506_102106_rbac_init', '1477939809');
INSERT INTO `migration` VALUES ('m161030_170236_create_user_table', '1477939810');
INSERT INTO `migration` VALUES ('m161030_170244_create_post_table', '1477939811');

-- ----------------------------
-- Table structure for post
-- ----------------------------
DROP TABLE IF EXISTS `post`;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_user_id_fkey` (`user_id`),
  CONSTRAINT `post_user_id_fkey` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of post
-- ----------------------------
INSERT INTO `post` VALUES ('1', '5', 'Fugit quibusdam.', 'bd16237bebbd65dc30db15c9cf043154.jpg', 'Magni et corrupti officiis officia voluptatibus. Repellat accusamus eligendi a quaerat est. Sunt non tenetur repellat dolores doloribus consequatur qui illo. Aut sint deserunt quis provident commodi quaerat.\nCommodi quos omnis ad labore voluptatem. Aut voluptates et fugiat consectetur. Voluptatibus qui deserunt id dolores consequatur quod.\nVoluptatem doloribus molestiae libero. Voluptatem nam repudiandae quaerat necessitatibus dicta et debitis. Deleniti aut esse id sunt vero molestiae nihil.\nVoluptas iusto et voluptatem distinctio temporibus molestiae ducimus. Eos asperiores amet rerum modi perspiciatis. Nemo laborum vero sit eos tempora. Dolor laudantium corporis nostrum tempora facilis et fuga.\nEarum est debitis nihil atque officiis sit. Labore at enim nihil dignissimos.\nMolestiae aspernatur vel dolores. Alias quibusdam necessitatibus autem laudantium similique in. Reprehenderit sapiente sed qui possimus quasi reiciendis. Blanditiis officiis minima sapiente nulla.\nAsperiores voluptatibus omnis accusamus quaerat rerum et harum. Assumenda qui similique aut molestiae laboriosam unde. Perferendis quis reiciendis ducimus aut.\nIpsa repellat maxime omnis exercitationem earum. Consequatur error veniam amet ut quas. Illum necessitatibus libero voluptatem.\nItaque consectetur laboriosam et reiciendis ut et quasi. Molestiae aspernatur suscipit necessitatibus quia. Nesciunt sequi ea corporis autem nobis et.', '10', '1477942738', '1477942738', null, null);
INSERT INTO `post` VALUES ('2', '6', 'Odio soluta enim eum ut.', '584e24148747ba849d657982a56c0d93.jpg', 'Tempore dolor non ipsum quaerat nostrum rerum nulla rerum. Ipsa id ut voluptas voluptatum aut. Est porro ut repellat quia commodi consequatur quos. Eveniet laboriosam ut pariatur officia provident beatae.\nA vero dolor quam quia beatae velit. Blanditiis maxime tempore possimus possimus. Et ipsam explicabo consequatur officiis consequatur voluptas. Ad aut et aperiam dignissimos molestiae est in.\nAut quia accusantium est dolorum reiciendis quam possimus. Pariatur id enim qui debitis. Quo consequatur voluptas sit tempore sunt. Soluta quia asperiores velit et.\nRerum voluptatum odit quis quas. Aut sunt iste adipisci blanditiis dicta nisi. Quia qui saepe quia. Maxime pariatur similique et sequi maiores.\nEst mollitia perferendis fugit itaque molestiae. Consequuntur ipsum exercitationem occaecati. Qui sit quam eum facilis aspernatur natus. Quas est dolorem unde blanditiis.\nEst quo ipsa corrupti omnis omnis alias aut. Error dolorem quae voluptatem inventore neque. Natus odit quidem ratione ratione. Tenetur tenetur laborum sed est aut.', '10', '1477942743', '1477942744', null, null);
INSERT INTO `post` VALUES ('3', '7', 'Fugit molestiae sit.', '02f6ed4165b8df726efcf0905921224e.jpg', 'Aspernatur reprehenderit tempora quae temporibus. Corrupti dolorem corporis dolores iusto quae quia sed ipsam. Eos voluptates hic nihil impedit qui.\nAutem officia id et autem dolore. Nisi quae consequatur et distinctio dolorem commodi ducimus odit. Eos officia voluptatem inventore sunt voluptate possimus illo.\nIure quod officia dignissimos. Soluta ea omnis eveniet eum. Culpa vel architecto illo quae ullam minima est. Qui rerum et blanditiis hic labore iure sit.\nFugit accusamus consequatur est non deleniti. Quaerat velit et voluptas quidem. Placeat ea quis illum provident.\nRerum autem laudantium in. Qui iure soluta occaecati et aliquid praesentium eum. Maxime aperiam ipsum eligendi et. Tenetur ullam omnis at fuga quia vel.\nVoluptate omnis consequatur tempore ex provident odit. Consequatur enim magnam qui ut velit quis. Sapiente deserunt repellat qui nostrum. Asperiores totam quasi tenetur ratione at.\nQuam accusamus voluptates aut odit consectetur possimus placeat accusamus. Iste architecto mollitia dicta et et dicta odit. Sunt aut eos et aut nobis exercitationem aliquam.', '10', '1477942749', '1477942749', null, null);
INSERT INTO `post` VALUES ('4', '2', 'Ut ab quod qui corrupti.', '63b4243a1f0089cd3cf6a97baf8ef7d2.jpg', 'Laborum vitae voluptatem pariatur corrupti. Laudantium voluptas qui harum eos assumenda. Deleniti quos ad ut enim quasi qui deleniti. Voluptas nostrum unde facere nostrum non ducimus.\nMolestias atque consequatur laboriosam qui dolor quis ea. Dolores reprehenderit dolore odio velit qui. In harum perspiciatis aspernatur aut consequuntur quia.\nEius facilis ut molestias molestias. Fuga ut repellendus neque sint. Qui voluptate dolorum quaerat necessitatibus cupiditate et aut. Voluptatibus omnis est minus quo ut.\nTemporibus dolores ipsam ut dolore incidunt voluptates. Id officiis ab nihil pariatur. Fuga cumque blanditiis sed nemo. Fugit error esse doloribus consectetur eaque.\nEos ipsa quibusdam est. Id nam qui aliquid voluptate asperiores autem et. Quasi iusto ut ex nemo est sit. A temporibus repellendus repellendus nobis suscipit debitis quia.\nEst quia inventore maiores veniam perferendis dolor ut. Rerum minima enim ipsum facilis ipsa.\nNostrum adipisci minima consequatur delectus praesentium. Sequi et at possimus sit earum.', '10', '1477942755', '1477942755', null, null);
INSERT INTO `post` VALUES ('5', '3', 'Nesciunt sint.', '0182fb1a16a5592b90145f03c35de320.jpg', 'Voluptatem corrupti est officia. Dolor sed vitae consequatur id. Assumenda aut nesciunt mollitia porro dolorem eos. Deserunt eum temporibus et sit iusto. Vel beatae repellendus eos eligendi sed.\nAut ullam necessitatibus iure eos. Est labore quis dolores architecto non officia. Adipisci fuga quam quis qui.\nRerum quia voluptas laborum commodi. Minus sapiente sed nesciunt ut. Vero soluta delectus ipsa rerum omnis nostrum aspernatur.\nDolores nam beatae consequatur dolores reprehenderit nihil. Debitis doloremque voluptas fugit quas nihil. Iste ab aut et esse est vitae. Quaerat voluptatem rerum quo corporis corporis omnis qui occaecati.\nNam ex alias vel quia reprehenderit. Provident ratione voluptas nam rerum iusto voluptas. Amet officia amet numquam quae reiciendis. Suscipit recusandae et eveniet esse qui blanditiis iusto.\nQui velit voluptate quasi a vero. Numquam ut expedita maxime quia et magnam aliquid. Ut ducimus sint neque aut.', '10', '1477942763', '1477942763', null, null);
INSERT INTO `post` VALUES ('6', '2', 'Dolor in vel dolores.', '5c287475a699f7cfa73049e5ec641910.jpg', 'Quo sunt necessitatibus et quidem. Laboriosam sunt itaque occaecati recusandae architecto molestiae. Accusamus sint ipsa labore vel. Omnis autem debitis recusandae veniam molestiae aut fugiat.\nVeniam molestiae sit dolor quibusdam maxime dolorem amet. Ipsam dolorum tempora in.\nA quia tempora quo veritatis cum non quisquam. Consequuntur debitis quae amet velit perferendis dolore omnis. Quos deleniti dicta quis cumque totam sint.\nEnim quia dicta quo repellat numquam. Alias veniam facere ipsum quo ut nisi. Incidunt et corporis asperiores corrupti veniam ducimus.\nIn vitae aut error est quis et possimus. Ipsam enim qui molestiae. In cum deleniti eius molestiae reiciendis voluptates iure.\nOmnis aut dignissimos porro non nihil cum similique. Voluptatibus voluptas molestias alias sed commodi. Voluptate ut est eaque maxime aut et. Et sapiente cumque repellendus quis saepe.\nVoluptatum tempora qui sed eius sunt qui et maxime. Et nobis consequuntur qui sit sunt. Minus rerum sit quia ab. Ut assumenda non iste laboriosam sequi minus aut.', '10', '1477942767', '1477942767', null, null);
INSERT INTO `post` VALUES ('7', '1', 'Nemo et quaerat.', 'c01b07b9805a5b8ed32a4dfcf55041b9.jpg', 'Veritatis temporibus maxime sapiente repellat aut. Officia ex alias et labore laborum unde est. Molestiae vel qui dolorum est voluptatum vero nemo. Dicta ut magni aliquid id ducimus rerum quia.\nVoluptatibus voluptatem ea qui consequuntur. Possimus non omnis illo voluptatum distinctio dicta laborum. Optio rerum omnis quibusdam libero sapiente quia et. Nihil praesentium modi corporis earum rem non. Aut adipisci culpa eius quia veritatis quis quaerat est.\nQui odio rem sed natus provident dolore id. Fugiat et omnis ratione possimus commodi enim soluta cum. Nisi quis illum dolore cum.\nAut minima dolorem officia repellat neque distinctio minima. Alias quis aliquid perspiciatis id. Voluptatem dicta aperiam aut nisi eos repellendus quia.\nAccusamus accusamus soluta praesentium possimus ducimus est. Cupiditate ut ad iure ipsum vel. Quis cumque fuga hic at est excepturi magni.\nRerum pariatur illum nihil cumque in ea quasi. Est distinctio repudiandae consequatur aut cupiditate illo. Earum enim sed facere iste sed velit.\nPraesentium tempore ut voluptatem dolor. Amet et expedita sint. Non minima nihil iste sed adipisci doloremque cum. Sunt laudantium voluptatem occaecati veniam.\nRerum eos nihil placeat eos ut. Veniam unde hic repellat repellat voluptatibus quidem. Consequatur vitae expedita nisi est fugit accusantium.\nId est quo sapiente veniam. Aperiam corporis in eos. Sint nulla earum debitis.', '10', '1477942772', '1477942772', null, null);
INSERT INTO `post` VALUES ('8', '1', 'Aut voluptatum.', '547eb22701c59af0e69d5e433992df1b.jpg', 'Voluptatem nihil similique id qui. Eos aperiam quia deserunt quos. Ea molestiae repellat molestias velit. Omnis ab eos iste est.\nMollitia facere iusto minus soluta eaque unde. Voluptatum harum omnis necessitatibus reiciendis. Impedit nisi magnam autem aspernatur molestiae qui. Nostrum non perferendis vel quas maxime odit doloribus. Repellat ut harum porro dignissimos deleniti.\nPossimus optio exercitationem sapiente. Animi molestiae ad velit consequuntur quo quibusdam. Quia minus eius laudantium doloribus aut voluptatem suscipit. Sint quidem id aut.\nQuae amet labore molestiae laborum. Et odio et aliquid quidem error ut hic. Ullam recusandae rerum repellendus dolorem unde. Temporibus voluptas eveniet maiores.\nDucimus qui quis libero quia suscipit ut ipsum. Aut deleniti quod nobis voluptatibus. Earum et provident nihil enim.\nAccusamus consequatur ut quod ut sit ut. Inventore ut ut doloribus esse neque modi perspiciatis. Alias explicabo beatae cumque quos.\nCulpa qui placeat eveniet quam nesciunt explicabo nam. Laborum sint eos rerum tempore. Earum esse voluptatem quidem similique rerum aut.\nIncidunt eos sed quasi iure. Et non qui expedita voluptas error labore. Accusantium soluta iste sunt ea cum dolorem. Odio quia explicabo neque accusamus error quibusdam accusamus.', '10', '1477942777', '1477942777', null, null);
INSERT INTO `post` VALUES ('9', '1', 'Eum vero est tempore.', '499a254e7f73de957e11584cbd782f7d.jpg', 'Exercitationem quia reiciendis consequatur sequi dolorum in enim ipsum. Sed vitae esse doloremque sit. Nihil est sit perferendis blanditiis.\nIllum fuga officiis recusandae nemo fugiat. Quia consequatur eius minus a. Sed tempora ipsa dolor animi odio adipisci. Unde asperiores omnis commodi laborum aut.\nAb tempora illum in voluptatem cumque est aliquid recusandae. Quo distinctio minima amet dignissimos.\nLabore consequuntur unde placeat dicta aspernatur aliquam neque enim. Molestiae provident consequatur rerum id. Perspiciatis modi commodi porro rem tenetur. Vitae animi iste unde enim accusantium quis.\nEt non enim ea error at. Odio provident eveniet possimus iusto accusamus vel dolores. Ut illo iusto consectetur accusamus itaque cupiditate. Quod consequatur sit eum quos officia in officia.\nAmet rerum veritatis fuga nisi laudantium. Aspernatur omnis consequuntur deserunt deleniti. Accusantium dicta ratione quae earum. Vitae ut aut rerum labore velit illo non.', '10', '1477942782', '1477942782', null, null);
INSERT INTO `post` VALUES ('10', '5', 'Enim porro incidunt et.', '9f65d0d6cdee350e88715b691c65f83a.jpg', 'Libero nam omnis et neque. Totam quo facere ut. Ducimus ut aut quia iste. Dolor soluta error eligendi sed dolore vel magni.\nEt voluptatem distinctio assumenda optio consequatur. Sunt neque nisi qui placeat. Quibusdam quia commodi minima fugiat debitis officia. Omnis beatae amet est dolorum aliquam vero qui.\nOdit tempore hic ut veniam necessitatibus cum. Quo sed praesentium sunt cumque odio. Perspiciatis ab molestiae molestiae in nihil veritatis unde. Velit et modi laudantium amet ea.\nAspernatur est magni nulla ab ut qui. Assumenda id illum quas cum velit tempora. Sit provident qui minus omnis. Pariatur est et eveniet fugiat voluptate reiciendis.\nCommodi doloremque est earum ex nihil. Nulla voluptatem sit qui repellat aut voluptas. Praesentium eum tempore incidunt illo. Libero ut enim sit libero ad laudantium totam.\nVel molestias sit et eum. In molestiae et est ut. Perspiciatis non et alias eos alias iusto odit. Accusantium illum maiores architecto officiis dolores ut voluptas.\nIure voluptatem id animi ut. Error perferendis aut quisquam. Ut et animi perferendis ipsum. Praesentium illo voluptatem sed nihil sapiente.\nNemo molestiae at voluptates sunt est accusantium quis. Incidunt dolore magni et impedit dolor error. Facere dicta nostrum ex et voluptatem sed. Aliquam dolorem natus ut distinctio et sequi.', '10', '1477942787', '1477942787', null, null);
INSERT INTO `post` VALUES ('11', '8', 'Omnis cum et dolore.', 'e3363d2feee917da0a438a989e72b0d6.jpg', 'Doloremque quis distinctio voluptatem quo laborum. Iste repudiandae eos repellendus beatae sequi maiores nostrum. Ipsam est et illum cupiditate nisi et delectus quod.\nEa rerum aliquam qui officia. Atque libero aliquid ducimus in dolore praesentium. Sed possimus nostrum illum voluptas.\nVeritatis autem aliquid eum beatae harum deserunt. Assumenda animi mollitia eos numquam. Ullam dolores nihil quis et minus. Quo voluptatem et ea totam.\nInventore quia sapiente minus eligendi voluptatem. Aliquid ut incidunt dolorem nam nihil non quas. Aut ut ullam alias delectus nostrum quo.\nEt aliquid veniam accusamus ea iusto. Corrupti vel voluptatem quia autem et dolor rerum. Dolore non dolorem illo qui. At rerum in dicta.\nIllum nihil eos accusamus ut in ut. Sunt vel sint quis vel dolorem est. Voluptatem rem et ipsam eius. Tempora error ratione cum eos. Odio voluptates pariatur id consequatur.\nFacilis qui sed cupiditate qui natus. Ab ab commodi aut accusamus consectetur repudiandae itaque. Dolore repellat ducimus voluptas impedit. Porro hic eveniet sint porro.\nSit veritatis est inventore repudiandae molestias. Vel tempora sunt sunt dolor. Dolorum assumenda commodi aut perspiciatis.\nDeleniti eaque consequatur quod quibusdam accusantium. Ullam quae tempora illum et nesciunt corporis vel et. Aut dolorum voluptatem dolor sed temporibus minima.', '10', '1477942792', '1477942792', null, null);
INSERT INTO `post` VALUES ('12', '4', 'Et voluptatem in unde.', '8f53399e46e3b0ee5a57ab40f0af96bf.jpg', 'Nisi consectetur ut consequuntur eveniet quis. Eligendi quam beatae in temporibus iste aut. Fugit ex voluptatum sapiente asperiores eveniet consequatur. Vero facilis eligendi odit ducimus ut nostrum maiores. Est fugiat dignissimos id quo.\nEt sit vero sunt necessitatibus adipisci quisquam. Illum dolor pariatur et ratione ea nihil. Corporis necessitatibus hic molestias sequi harum voluptatem nostrum. Doloremque natus doloribus labore suscipit impedit consequatur cumque.\nPerspiciatis ullam ratione dolores et accusantium dolores. Hic occaecati eum aut optio earum quas. Voluptas qui incidunt enim omnis ducimus ea. Officia ea quia voluptates quasi et.\nOccaecati commodi et voluptatibus quod commodi ipsum. Illum soluta sit nostrum atque unde. Inventore ut itaque aut in repellendus.\nDelectus harum soluta exercitationem porro quibusdam commodi sint deleniti. Ea consectetur blanditiis explicabo deserunt. Quo velit dolores odio. Vero est qui in perferendis hic et ea aut.\nSoluta quis nisi ut qui eius sed dolores tempore. Nobis dicta quis quia omnis quia quis. Similique aut enim veritatis est vel magnam. Nam cupiditate nulla libero odit labore.\nAut accusantium nostrum perferendis illo illo. Corrupti provident aperiam ut ut. Excepturi rerum tempora natus ab rerum. Expedita id ut saepe sunt labore magnam.\nId voluptas qui et reiciendis laboriosam. Iusto possimus ipsa id quo labore est maxime voluptatem.', '10', '1477942797', '1477942797', null, null);
INSERT INTO `post` VALUES ('13', '8', 'Aut omnis dolor voluptas.', 'e6b8bd45de51d0669f8690a686bcc88d.jpg', 'Cupiditate hic excepturi laboriosam rerum cupiditate. Ducimus beatae blanditiis adipisci earum. Earum ipsa veniam omnis asperiores expedita sapiente.\nQui suscipit aut ea et. Esse et velit voluptas voluptatem laborum facilis officia. Ab in laboriosam velit quia. Deleniti iure vel quasi et at dolore.\nVelit quas officia laborum quae. Impedit hic aut nulla aut beatae. Maxime optio itaque magnam cum.\nUt minus impedit impedit. Quia vel libero ab ut quos molestiae quibusdam. Iure consequatur minima nulla tenetur molestiae harum voluptas. Assumenda voluptatem est aspernatur repellendus omnis esse.\nAnimi qui amet non voluptates. Nobis et omnis quae hic numquam. Laboriosam nihil qui itaque quisquam consequatur.\nNobis rerum est modi ut est qui. Doloribus et aut repudiandae. Distinctio accusantium dolor vel ducimus qui occaecati harum perspiciatis. Maiores tempore accusamus deleniti iure cumque laboriosam.\nEst minus dolorum voluptas eum veniam neque rerum. Mollitia non alias alias suscipit. Rerum dolore suscipit ullam aut distinctio odio delectus.\nQuia soluta repellendus sequi sunt ipsum id nostrum sapiente. Possimus voluptatem quas qui voluptatum.\nVoluptatem debitis sit aliquid. Facere et odit et numquam. Incidunt doloremque quis libero ut distinctio.\nAtque voluptas reiciendis nihil nulla voluptate quos amet. Harum magnam voluptatem aliquid vero error occaecati. Soluta sed ex commodi ducimus quis.', '10', '1477942801', '1477942801', null, null);
INSERT INTO `post` VALUES ('14', '6', 'Sint ratione inventore.', 'f14515e53da117aecb175be8b0855b74.jpg', 'Veniam et optio voluptas enim animi facere et. Qui hic ab eum omnis velit recusandae sint. Commodi sit ducimus quia. Magnam dolor rem accusamus perspiciatis laborum sint.\nQuos at perspiciatis sint. Ad voluptatem reprehenderit eveniet autem. Voluptatibus eligendi incidunt similique dolorem ullam ut autem commodi.\nQuia fugit possimus quia et dolore enim praesentium. Dolorem sequi perspiciatis adipisci. Inventore cumque doloribus et corrupti libero distinctio. Quos unde incidunt ut blanditiis amet.\nTenetur et qui velit incidunt aliquid dolore. Libero quam illum sint magni. Quos et inventore voluptate natus non. Voluptatem aliquid provident eius eos quas expedita.\nEx quibusdam quaerat nobis sit sit laboriosam. Quia quia et similique deleniti. Nemo delectus cupiditate tempore quasi consequuntur perferendis aut eius.\nSit aut vero in provident eos. Voluptas id et provident qui. Consequatur cumque similique laboriosam earum sed sunt.\nNon et et id molestias. Sit ut dicta ea natus ut esse ratione. Provident odit voluptas eligendi impedit.\nDebitis odit ea nulla et eos. Incidunt quisquam doloremque in cumque aliquid temporibus facilis unde. Unde quae neque nesciunt explicabo vel rem repellat. Quia rerum quo nulla nam inventore.\nAtque ad et a commodi. Vel voluptatem aliquam hic laboriosam atque. Expedita libero amet nostrum enim.', '10', '1477942806', '1477942806', null, null);
INSERT INTO `post` VALUES ('15', '5', 'Non harum rerum sequi.', 'a4fa5f6960a9d13082d7c34262da6de9.jpg', 'Est voluptas qui voluptate deleniti est in vero. Eos quis ipsum et officia odit. Distinctio dolor sint tenetur quisquam ipsum.\nAlias sequi vel consectetur ea optio voluptatem. Distinctio facilis est velit asperiores et. Aut eos dolores doloremque sit nihil nisi. Occaecati maiores quia qui voluptatem autem tempore.\nDucimus enim suscipit iusto tempora est autem aut. Magni omnis fugiat voluptate quaerat nostrum dignissimos. Sit omnis qui sit molestias dolor.\nEst quo qui nam nisi officia. Voluptatem nulla illo temporibus molestiae error voluptatem et. Ut officiis molestiae nemo consequatur.\nEt sed placeat repudiandae quidem repellendus natus. Ex a vero et accusantium quos labore saepe harum. Repellat sunt deleniti est accusantium.\nVoluptatibus commodi necessitatibus assumenda qui velit dolores. Provident omnis sit in et. Totam eveniet in quos et esse voluptatem. Eum harum consequuntur non veritatis. Necessitatibus blanditiis libero sint voluptas eligendi qui.', '10', '1477942811', '1477942812', null, null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'Kürşat', 'Yiğitoğlu', 'w_skNvPXdtVb1XIqXSiOc2CzJHcAg_tt', '$2y$13$MKHXtYP/yw8GAAQZH.uas.CMjL7j7s/SekxJ0HgHFV7MevtAb3Bli', null, 'kursat.yigitoglu@gmail.com', '10', '1477940358', '1477951043', null, null);
INSERT INTO `user` VALUES ('2', 'Isobel', 'Murphy', 'FHWvmaqxDnAFwetLGDJyGVDQGfybn3sh', '$2y$13$K9V97QR5T2fSIfNXh4P.de.iihdKAWdTWEnGvUOc.ZN2irGWfPDYS', null, 'fwalker@hall.com', '10', '1477941714', '1477941714', null, null);
INSERT INTO `user` VALUES ('3', 'Ellie', 'White', '0teur3Nq1oqb9lcfjI7kQyyaMDt7s__G', '$2y$13$N4R2dl79WGl1i6P3VjN5vuKhJlCgWw13/co4zUR24lXYnm/bDQeRG', null, 'duncan77@hotmail.co.uk', '10', '1477941715', '1477941715', null, null);
INSERT INTO `user` VALUES ('4', 'Rosie', 'Wood', 'i8XNDik7hwJEBA6onc8k5cb7BKDpae0l', '$2y$13$Q8Lv7YiQ60dmpegOj.ZmpO6l7pTPQPV5Q0YoCdilLJR2nJpSvIvES', null, 'price.gary@yahoo.com', '10', '1477941715', '1477941715', null, null);
INSERT INTO `user` VALUES ('5', 'Suzanne', 'Robinson', 'vhjemQm7ynfHTxa2UkJOnukouUEjzAzo', '$2y$13$c92WNxLC3PgwXRb4h6j/jubsFf8DvP/FFHrb4WoeLECr9.y3u2C.e', null, 'owen.baker@richardson.net', '10', '1477941716', '1477941716', null, null);
INSERT INTO `user` VALUES ('6', 'Oscar', 'Stewart', 'kIAjSaKQPj-0ZTn2Dt6zCiVuN56PsT-h', '$2y$13$gm1IoLeGlmyTf/SG2ePoNeMjuMubc/ivTndDcpWMJFWjq10b6Jie.', null, 'qmitchell@kelly.com', '10', '1477941716', '1477941716', null, null);
INSERT INTO `user` VALUES ('7', 'Sasha', 'Graham', 'U_gAGqHwyopwHQ7ix3NJXk8gb5MT6wjN', '$2y$13$.wlW17w1OMOtURp7tE7jpOsB02VImrF0SNZbuWyxQZL9CTiRxTs7q', null, 'rowena96@hughes.com', '10', '1477942731', '1477942731', null, null);
INSERT INTO `user` VALUES ('8', 'Eileen', 'Cox', 'PpqxuPOIT64iWXCmxglXFC1e1wdmDgCF', '$2y$13$0rVVo0YPKyC2jpJK4PVpL.UTjmTdeZPPDbjaol69kamqYr32WUeWe', null, 'carter.samuel@gmail.com', '10', '1477942732', '1477942732', null, null);
SET FOREIGN_KEY_CHECKS=1;
