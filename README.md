# mine-shop
PHP website supports Minecraft Spigot/Bukkit servers.
```
Get servers (recommend): https://getbukkit.org/download/spigot
```
![Demo_image](https://i.imgur.com/ZdzmVeS.png)

# Install
Recommend Apache XAMPP: https://www.apachefriends.org/download.html.<br>
Just copy & paste to htdocs (*C:/xampp/htdocs*). Import file **minecraft.sql** to MySQL. Finally, change file **config.php**.

# Plugins
- Login Security: https://dev.bukkit.org/projects/loginsecurity
- SkinsRestorer: https://www.spigotmc.org/resources/skinsrestorer.2124/

## Config Login Security
Go to **{minecraft_server}\plugins\LoginSecurity** and change file **database.yml**
```
isolation: SERIALIZABLE
mysql:
  enabled: true <---- CHANGE THIS FROM FALSE TO TRUE
  host: 'localhost:3306'
  username: 'root'
  password: ''
  # Table names are prefixed with ls_
  database: 'minecraft'
```

# Config server.properties
Turn on rcon and query of Minrecraft Server
```
# Rcon
rcon.password=password@abc <------ RCON Password (Required)
enable-rcon=true <------ TRUE

# Query
enable-query=true <------ TRUE
```

# Credits
- PHP code by [Vy Nghia](https://www.facebook.com/nghiadev)
- Thanks [xPaw](https://github.com/xPaw/PHP-Minecraft-Query) (Query source) &  [thedudeguy](https://github.com/thedudeguy/PHP-Minecraft-Rcon) (RCon source)
