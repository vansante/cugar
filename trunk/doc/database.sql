CREATE TABLE device (
      device_id     int NOT NULL
);


ALTER TABLE device ADD PRIMARY KEY (device_id);



CREATE TABLE configuration (
      configuration_id     int NOT NULL,
      device_id     int,
      channel     int,
      wireless_mode     enum('a','b','g'),
      update_server     varchar(255),
      device_device_id     int NOT NULL
);


ALTER TABLE configuration ADD PRIMARY KEY (configuration_id);



CREATE TABLE ssid_config (
      configuration_id     int,
      name     varchar(32),
      vlan     int,
      group_rekey_interval     int,
      ssid_config_id     int NOT NULL,
      broadcast     enum('true','false'),
      strict_rekey     enum('true','false'),
      passphrase     varchar(255),
      wpa_mode     enum('wpa','wpa2','off'),
      configuration_configuration_id     int NOT NULL
);


ALTER TABLE ssid_config ADD PRIMARY KEY (ssid_config_id);



CREATE TABLE mode2 (
      configuration_id     int,
      mode2_id     int NOT NULL,
      file_path     varchar(255),
      configuration_configuration_id     int NOT NULL
);


ALTER TABLE mode2 ADD PRIMARY KEY (mode2_id);



CREATE TABLE mode3 (
      configuration_id     int,
      mode3_id     int NOT NULL,
      retry_interval     int,
      own_ip     varchar(15),
      nas_identifier     varchar(255),
      configuration_configuration_id     int NOT NULL,
      radius_id     int NOT NULL,
      tunnel_id     int NOT NULL
);


ALTER TABLE mode3 ADD PRIMARY KEY (mode3_id);



CREATE TABLE radiusserver (
      radius_id     int NOT NULL,
      mode3_id     int,
      type     enum('auth','acct'),
      ip     varchar(15),
      port     int,
      shared_secret     varchar(255),
      interim_interval     int
);


ALTER TABLE radiusserver ADD PRIMARY KEY (radius_id);



CREATE TABLE vpntunnels (
      tunnel_id     int NOT NULL,
      mode3_id     int,
      type     enum('auth','data'),
      server     varchar(15),
      port     int,
      cipher     varchar(100),
      compression     enum('true','false')
);


ALTER TABLE vpntunnels ADD PRIMARY KEY (tunnel_id);



CREATE TABLE dhcp_relay (
      configuration_id     int,
      dhcp_relay_id     int NOT NULL,
      server_ip     varchar(15),
      hw_interface     varchar(32),
      configuration_configuration_id     int NOT NULL
);


ALTER TABLE dhcp_relay ADD PRIMARY KEY (dhcp_relay_id);





ALTER TABLE configuration ADD FOREIGN KEY (device_device_id) REFERENCES device (device_id);


ALTER TABLE ssid_config ADD FOREIGN KEY (configuration_configuration_id) REFERENCES configuration (configuration_id);


ALTER TABLE mode2 ADD FOREIGN KEY (configuration_configuration_id) REFERENCES configuration (configuration_id);


ALTER TABLE mode3 ADD FOREIGN KEY (configuration_configuration_id) REFERENCES configuration (configuration_id);
ALTER TABLE mode3 ADD FOREIGN KEY (radius_id) REFERENCES radiusserver (radius_id);
ALTER TABLE mode3 ADD FOREIGN KEY (tunnel_id) REFERENCES vpntunnels (tunnel_id);






ALTER TABLE dhcp_relay ADD FOREIGN KEY (configuration_configuration_id) REFERENCES configuration (configuration_id);


