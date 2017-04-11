
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




