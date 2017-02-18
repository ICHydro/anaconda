
-- add some dummy data to kickstart the installation

INSERT INTO "role" ("id", "name", "created_at", "updated_at", "can_admin") VALUES
(1, 'Admin', '2015-12-23 12:53:11', NULL, 1),
(2, 'User', '2015-12-23 12:53:11', NULL, 0);


INSERT INTO "user" ("id", "role_id", "status", "email", "username", "password", "auth_key", "access_token", "logged_in_ip", "logged_in_at", "created_ip", "created_at", "updated_at", "banned_at", "banned_reason") VALUES
(1, 1, 1, 'neo@neo.com', 'neo', '$2y$13$dyVw4WkZGkABf2UrGWrhHO4ZmVBv.K4puhOL59Y9jQhIdj63TlV.O', 'sB-taQ_hcmvBecCmIN0df3FptS9nabDc', 'FggrSfeqersuWKrKDeKWBQ0RuPEW1vC2', '127.0.0.1', '2016-05-01 20:05:35', NULL, '2015-12-23 12:53:11', NULL, NULL, NULL),
(2, 2, 1, 'bart.demaesschalck@gmail.com', 'test', '$2y$13$mHKbYQtg30G.n3vomNGmaOithwPTO3NNhuQQKeojLYqKwzZ0rUr1C', NULL, NULL, '127.0.0.1', '2016-05-01 20:09:14', NULL, '2016-05-01 19:57:02', '2016-05-01 19:57:02', NULL, NULL),
(3, 1, 1, 'w.buytaert@imperial.ac.uk', 'admin', '$2y$13$DLwSclZTa3xY/Ixl53Dnp.qhYmgbx9W8Q9m0mpXSijU4dVB.1d/kK', NULL, NULL, NULL, NULL, NULL, '2016-05-01 21:22:52', '2016-05-01 21:22:52', NULL, NULL);


INSERT INTO "profile" ("id", "user_id", "created_at", "updated_at", "full_name") VALUES
(1, 1, '2015-12-23 12:53:11', '2016-05-01 19:41:06', 'the one'),
(2, 2, '2016-05-01 19:57:02', '2016-05-01 19:57:02', 'test'),
(3, 3, '2016-05-01 21:22:52', '2016-05-01 21:22:52', 'Wouter');


INSERT INTO "catchment" ("id", "name", "name_es", "name_ne", "description", "description_es", "description_ne") VALUES
(1, 'Catchment Area: One', 'Área de influencia : Uno', ' Catchment क्षेत्र : एक', 'Catchment areas (especially Catchment 1) are generally established and modified by local governments. These boundaries can be modeled using geographic information systems (GIS).There can be large variability in the services provided within different catchments in the same area depending upon how and when those catchments were established. They are usually contiguous but can overlap when they describe competing services', '\r\nLas zonas de captación (especialmente de captación 1 ) son generalmente establecidos y modificados por los gobiernos locales . Estos límites pueden ser modelados utilizando sistemas de información geográfica ( GIS ) .No puede ser una gran variabilidad en los servicios prestados en las diferentes zonas de captación en la misma zona , dependiendo de cómo y cuándo se establecieron esas cuencas . Por lo general son contiguas, sino que pueden solaparse cuando describen servicios de la competencia', 'Catchment क्षेत्रहरु ( विशेष गरी 1 Catchment ) साधारण स्थापित र परिमार्जन स्थानीय सरकारहरूले द्वारा छन् । यी सीमा भौगोलिक सूचना प्रणाली ( जीआईएस ) को प्रयोग गरेर .त्यहाँ ती catchments स्थापित थिए कसरी र कहिले निर्भर गर्दछ नै क्षेत्रमा विभिन्न catchments भित्र प्रदान सेवाहरूमा ठूलो variability हुन सक्छ modeled गर्न सकिन्छ। तिनीहरूले सामान्यतया सन्निहित छन् तर तिनीहरूले प्रतिस्पर्धा सेवाहरू वर्णन गर्दा ओभरल्याप गर्न सक्नुहुन्छ'),
(2, 'Catchment Area: Two', 'Área de influencia : Dos', 'Catchment स्थान: दुई', 'Catchment areas (especially Catchment 2) are generally established and modified by local governments. These boundaries can be modeled using geographic information systems (GIS).There can be large variability in the services provided within different catchments in the same area depending upon how and when those catchments were established. They are usually contiguous but can overlap when they describe competing services', 'Las zonas de captación (especialmente de captación 2 ) son generalmente establecidos y modificados por los gobiernos locales . Estos límites pueden ser modelados utilizando sistemas de información geográfica ( GIS ) .No puede ser una gran variabilidad en los servicios prestados en las diferentes zonas de captación en la misma zona , dependiendo de cómo y cuándo se establecieron esas cuencas . Por lo general son contiguas, sino que pueden solaparse cuando describen servicios de la competencia\r\n', 'Catchment क्षेत्रहरु ( विशेष गरी 2 Catchment ) साधारण स्थापित र परिमार्जन स्थानीय सरकारहरूले द्वारा छन् । यी सीमा भौगोलिक सूचना प्रणाली ( जीआईएस ) को प्रयोग गरेर .त्यहाँ ती catchments स्थापित थिए कसरी र कहिले निर्भर गर्दछ नै क्षेत्रमा विभिन्न catchments भित्र प्रदान सेवाहरूमा ठूलो variability हुन सक्छ modeled गर्न सकिन्छ। तिनीहरूले सामान्यतया सन्निहित छन् तर तिनीहरूले प्रतिस्पर्धा सेवाहरू वर्णन गर्दा ओभरल्याप गर्न सक्नुहुन्छ'),
(3, 'Catchment Area: 3', 'Área de influencia : 3', 'Catchment स्थान: 3', 'Catchment areas (especially Catchment 3) are generally established and modified by local governments. These boundaries can be modeled using geographic information systems (GIS).There can be large variability in the services provided within different catchments in the same area depending upon how and when those catchments were established. They are usually contiguous but can overlap when they describe competing services', 'Las zonas de captación (especialmente de captación 3 ) son generalmente establecidos y modificados por los gobiernos locales . Estos límites pueden ser modelados utilizando sistemas de información geográfica ( GIS ) .No puede ser una gran variabilidad en los servicios prestados en las diferentes zonas de captación en la misma zona , dependiendo de cómo y cuándo se establecieron esas cuencas . Por lo general son contiguas, sino que pueden solaparse cuando describen servicios de la competencia\r\n', 'Catchment क्षेत्रहरु ( विशेष गरी 3 Catchment ) साधारण स्थापित र परिमार्जन स्थानीय सरकारहरूले द्वारा छन् । यी सीमा भौगोलिक सूचना प्रणाली ( जीआईएस ) को प्रयोग गरेर .त्यहाँ ती catchments स्थापित थिए कसरी र कहिले निर्भर गर्दछ नै क्षेत्रमा विभिन्न catchments भित्र प्रदान सेवाहरूमा ठूलो variability हुन सक्छ modeled गर्न सकिन्छ। तिनीहरूले सामान्यतया सन्निहित छन् तर तिनीहरूले प्रतिस्पर्धा सेवाहरू वर्णन गर्दा ओभरल्याप गर्न सक्नुहुन्छ');



INSERT INTO "sensor" ("id", "name", "catchmentid", "latitude", "longitude", "sensortype", "units", "height", "width", "angle", "property", "admin_email") VALUES
(1, 'sensor 1', 1, 10, 10, 'Weighing Gauge', NULL, 10, 10, 520, NULL, NULL),
(2, 'Sensor 2', 1, 13, 123, 'Weighing Gauge', NULL, 10, 10, 250, NULL, NULL),
(4, 'S2123', 1, 10, 10, 'Weighing Gauge', NULL, NULL, NULL, NULL, NULL, NULL),
(5, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(6, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(7, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(8, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(9, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(10, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(11, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(12, '123456', 1, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, '0', 'lalala@example.com'),
(13, '123456', 1, 20, 40, 'Weighing Gauge', 'inch', NULL, NULL, NULL, 'Observation 2', 'lalala@example.com'),
(14, '', 2, 20, 40, 'Weighing Gauge', 'mm', NULL, NULL, NULL, 'Observation 2', 'bart.demaesschalck@gmail.com'),
(15, '123123', 2, 20, 20, 'Weighing Gauge', 'inch', NULL, NULL, NULL, 'Observation 2', 'bart.demaesschalck@gmail.com'),
(16, 'Sensor 3', 2, 20, 40, 'Weighing Gauge', 'inch', NULL, NULL, NULL, 'Observation 2', 'bart.demaesschalck@gmail.com');


-- INSERT INTO migration (version, apply_time) VALUES
-- ('m000000_000000_base', 1450878781),
-- ('m150214_044831_init_user', 1450878791),
-- ('m170610_152817_i18n', 1462146099);




